<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use App\Models\UsersAdd;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Purchase;
use App\Models\Items_comment;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\UploadRequest;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');
        $user = auth()->user();

        if ($user) {
            if ($tab === 'mylist') {
                $favoriteItemIds = Favorite::where('user_id', $user->id)
                    ->pluck('item_id');
                $query = Item::whereIn('id', $favoriteItemIds)
                    ->where('user_id', '!=', $user->id);
            } else {
                $query = Item::where('user_id', '!=', $user->id);
            }
        } else {
            if ($tab === 'mylist') {
                $query = Item::whereRaw('0 = 1');;
            } else {
                $query = Item::query();
            }
        }

        if ($keyword) {
            $query->where('item_name', 'like', "%{$keyword}%");
        }

        $items = $query->get();

        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        return view('index', compact('items', 'tab', 'purchasedItemIds'));
    }

    public function mypage(Request $request)
    {
        $page = $request->query('page');
        $user = auth()->user();
        $userId = auth()->id();

        if ($user) {
            if ($page === 'buy') {
                $buyItemIds = Purchase::where('user_id', $user->id)
                    ->pluck('item_id');
                $query = Item::whereIn('id', $buyItemIds)
                    ->where('user_id', '!=', $user->id);
            } else {
                $query = Item::where('user_id', '=', $user->id);
            }
        }

        $items = $query->get();
        $users = User::find($userId);
        $userAdd = UsersAdd::where('user_id', $userId)->first();
        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        return view('mypage', compact('items', 'page', 'purchasedItemIds','users','userAdd'));
    }

    public function itemDetail($id)
    {
        $item = Item::where('id', $id)->first();
        $userId = auth()->id();
        $favorite = Favorite::where('user_id', $userId)
                            ->where('item_id', $id)
                            ->first();
        $item_comment = Items_comment::where('item_id', $id)->get();
        $purchasedItemIds = Purchase::pluck('item_id')->toArray();
        return view('item', compact('item', 'favorite','item_comment','purchasedItemIds'));
    }

    public function good(Request $request)
    {
        $userId = $request->user_id;
        $itemId = $request->item_id;

        $favorite = Favorite::where('user_id', $userId)
                            ->where('item_id', $itemId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => $userId,
                'item_id' => $itemId,
            ]);
        }

        $item = Item::where('id', $itemId)->first();
        $favorite = Favorite::where('user_id', $userId)
                            ->where('item_id', $itemId)
                            ->first();
        $item_comment = Items_comment::where('item_id', $itemId)->get();
        $purchasedItemIds = Purchase::pluck('item_id')->toArray();

        return redirect("/item/{$item->id}")
            ->with([
            'item' =>$item,
            'favorite' => $favorite,
            'item_comment' => $item_comment,
            'purchasedItemIds' => $purchasedItemIds,
        ]);
    }

    public function comment(CommentRequest $request)
    {
        $userId = $request->user_id;
        $itemId = $request->item_id;
        $comment = $request->comment;

        $item_comment = $request->only(['item_id', 'user_id', 'comment']);
        Items_comment::create($item_comment);

        return $this->itemDetail($itemId);
    }

    public function purchase(Request $request)
    {
        $userId = $request->user_id;
        $itemId = $request->item_id;
        $other_flg = '0';

        $item = Item::where('id', $itemId)->first();
        $useradd = UsersAdd::where('user_id', $userId)->first();

        return view('purchase', compact('item','useradd','other_flg'));
    }

    public function address(Request $request)
    {
        $itemId = $request->item_id;
        $item = Item::where('id', $itemId)->first();
        return view('address', compact('item'));
    }

    public function change(AddressRequest $request)
    {
        $userId = $request->user_id;
        $itemId = $request->item_id;
        $other_flg = '1';
        $other_post_code = $request->post_code;
        $other_address = $request->address;
        $other_building = $request->building;

        $item = Item::where('id', $itemId)->first();
        $useradd = UsersAdd::where('user_id', $userId)->first();

        session([
            'other_flg' => 1,
            'other_post_code' => $request->post_code,
            'other_address' => $request->address,
            'other_building' => $request->building,
            'useradd' => $useradd,
        ]);

        return redirect()->route('purchase.show', ['item_id' => $itemId]);
    }

    public function buy(PurchaseRequest $request)
    {
        $purchase = $request->only(['item_id',
                                    'user_id',
                                    'payment_method',
                                    'purchase_post_code',
                                    'purchase_address',
                                    'purchase_building']);
        Purchase::create($purchase);

        session()->forget([
            'other_flg',
            'other_post_code',
            'other_address',
            'other_building',
            'useradd',
        ]);

        $userId = $request->user_id;

        return redirect()->route('items.index');
    }

    public function sell(Request $request)
    {
        return view('sell');
    }

    public function image(UploadRequest $request)
    {
        $file = $request->file('image');
        $file_name = uniqid() . '.' . $file->getClientOriginalExtension();
        $request->file('image')->storeAs('/public/image/item',$file_name);

        session()->put('uploaded_file', $file_name);

        return redirect()->back();
    }

    public function setSell(ExhibitionRequest $request)
    {
        if ($request->has('image')) {
            session()->flash('uploaded_file', $request->image);
        }

        $categoryNames = [
            1 => 'ファッション',
            2 => '家電',
            3 => 'インテリア',
            4 => 'レディース',
            5 => 'メンズ',
            6 => 'コスメ',
            7 => '本',
            8 => 'ゲーム',
            9 => 'スポーツ',
            10 => 'キッチン',
            11 => 'ハンドメイド',
            12 => 'アクセサリー',
            13 => 'おもちゃ',
            14 => 'ベビー・キッズ',
        ];

        $item = $request->only(['user_id',
                                'item_name',
                                'brand_name',
                                'price',
                                'item_describe',
                                'image',
                                'condition']);

        $selectedCategories = [];
        foreach ($categoryNames as $id => $name) {
            $item["category{$id}"] = $request->input("category{$id}") == '1' ? $name : null;
        }

        Item::create($item);

        session()->forget('uploaded_file');

        return redirect('/mypage');
    }
}
