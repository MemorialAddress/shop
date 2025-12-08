# アプリケーション名

フリマアプリケーション

## 環境構築

- Docker テンプレートのクローン
  $ git clone git@github.com:MemorialAddress/shop.git

- Docker コンテナの作成(shop ディレクトリにて実行)
  $ docker-compose up -d --build

- Laravel パッケージのインストール
  $ docker-compose exec php bash
  ＃ composer install

- 環境定義ファイル作成
  $ cp .env.example .env

- .env ファイルの以下項目を変更
  DB_HOST=127.0.0.1 → DB_HOST=mysql
  DB_DATABASE=laravel → DB_DATABASE=laravel_db
  DB_USERNAME=root → DB_USERNAME=laravel_user
  DB_PASSWORD= → DB_PASSWORD=laravel_pass
  MAIL_FROM_ADDRESS=null → MAIL_FROM_ADDRESS=no-reply@example.com

- .env ファイルの以下項目を追加
  STRIPE_KEY="pk_test_51SWUXWCIWlRk5w6j3jPXidlUy8ELxXq6NlGoHwqLXnpIQTzvQqfuNL8oD7EPaYbw4YSpA9tRoJBqiE0BO2YrhrLt001eiHPzas"
  STRIPE_SECRET=「基本設計書（生徒様入力用）」に記載の文字列を転記
  STRIPE_WEBHOOK_SECRET=「基本設計書（生徒様入力用）」に記載を転記

- 暗号鍵採番
  $ docker-compose exec php bash
  ＃ php artisan key:generate

- テーブルマイグレーション、シーディング
  ＃ php artisan migrate
  ＃ php artisan db:seed

- シンボリックリンク設定
  ＃ php artisan storage:link

- Stripe 決済使用時は以下コマンドでコンテナ起動すること（決済完了でもって購入完了となる）
  $ docker run -it --rm --network host \
   -v $PWD:/workspace -w /workspace \
   stripe/stripe-cli listen \
   --forward-to http://host.docker.internal/webhook \
   --api-key 「基本設計書（生徒様入力用）」に記載の文字列を転記(ダブルコーテーション不要)
  ※カード払いの場合、カード番号は「4242424242424242」を入力すること。
  　コンビニ払いの場合、「支払う」押下後、約３分後に自動的に決済完了となる。

## テストユーザー

・メールアドレス：test1@example.com パスワード：password
・メールアドレス：test2@example.com パスワード：password
・メールアドレス：test3@example.com パスワード：password

## 使用技術

PHP：8.1.33
MySQL:8.0.26
Laravel:12.41.1
Stripe
mailhog

## ER 図

![alt text](image-1.png)

## URL

・開発環境： http://localhost/
・phpMyAdmin： http://localhost:8080/
・Mailhog： http://localhost:8025/

## PHPUnit テストコマンド

1.会員登録機能　# vendor/bin/phpunit tests/Feature/RegisteTest.php 2.ログイン機能　# vendor/bin/phpunit tests/Feature/LoginTest.php 3.ログアウト機能　# vendor/bin/phpunit tests/Feature/LogoutTest.php 4.商品一覧取得　# vendor/bin/phpunit tests/Feature/IndexTest.php 5.マイリスト一覧取得　# vendor/bin/phpunit tests/Feature/MylistTest.php 6.商品検索機能　# vendor/bin/phpunit tests/Feature/ItemsearchTest.php 7.商品詳細情報取得　# vendor/bin/phpunit tests/Feature/ItemdetailTest.php 8.いいね機能　# vendor/bin/phpunit tests/Feature/FavoriteTest.php 9.コメント送信機能　# vendor/bin/phpunit tests/Feature/CommnetTest.php 10.商品購入機能　# vendor/bin/phpunit tests/Feature/PurchaseTest.php 11.支払い方法選択機能　# vendor/bin/phpunit tests/Feature/PaymentTest.php 12.配送先変更機能　# vendor/bin/phpunit tests/Feature/AddressTest.php 13.ユーザー情報取得　# vendor/bin/phpunit tests/Feature/ProfileTest.php 14.ユーザー情報変更　# vendor/bin/phpunit tests/Feature/ProfileTest.php 15.出品商品情報登録　# vendor/bin/phpunit tests/Feature/SellTest.php 16.メール認証機能　# vendor/bin/phpunit tests/Feature/MailTest.php
