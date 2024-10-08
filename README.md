## アプリケーション名
    飲食店予約アプリ
<img width="650" src="https://github.com/user-attachments/assets/eb64bbf4-5ec6-44a9-bc30-557803cb39f3">



## 概要説明
    1 利用者が飲食店一覧から店舗情報を見て予約やお気に入り登録ができる

    2 店舗代表者と管理者がそれぞれの管理画面から情報の管理やお知らせメールを送信できる

    3 ユーザーは受け取った予約のリマインダーメールから決済やレビューが可能



## 作成目的
    1 利用者が飲食店を探すときにエリアやジャンル別で検索しスムーズに店舗を決められるように

    2 予約や決済、レビューなど全てをネット上で行えるようにして人的コスト削減や業務効率化を図るため

    3 シンプルな見た目と構成にして利用側と管理側のユーザーが直感的に使えるように



## アプリケーションURL
##### ローカル環境

http://localhost/

##### 本番環境（AWSデプロイ）
http://54.249.16.235/




## 機能一覧
    1 会員登録、ログイン機能

    2 メール認証

    3 ソート機能(飲食店一覧の並び替え)

    4 飲食店リアルタイム検索

    5 お気に入りの登録と取り消し機能(イイね♡押下)

    6 飲食店への予約機能(日付、時間、人数の指定可能)

    7 メニュー画面の切り替え

    8 飲食店代表者の作成 (管理者権限)

    9 CSVファイルのインポート機能 (管理者権限)

    10 飲食店情報の追加、編集 (飲食店代表者権限)

    11 各飲食店の予約情報の予約情報の確認 (飲食店代表者権限)

    12 ユーザーへのお知らせメール機能 (飲食店代表者権限)

    13 利用者へ予約日当日の午前9:00にリマインダーメールを送信

    14 stripe決済機能

    15 QRコードで予約情報の確認 (飲食店代表者権限)

    16 飲食店に対しての口コミ機能(レビュー)



## 詳細内容
    シーディングで管理者と店舗代表者が作成される
      管理者(admin)としてアクセスする場合
      - email: admin@example.com    password: 00000000
      店舗代表者(store_manager)としてアクセスする場合
      - email: manager@example.com    password: 99999999

    メール認証
      本人確認をしないと飲食店の予約ができない

    ソート機能
      評価の高い順/低い順、ランダムでの並び替えが可能

    飲食店リアルタイム検索
      エリア、ジャンル、キーワードで絞り込み検索が可能

    メニュー画面の切り替え
      ゲスト/ログインユーザー、admin/store_managerでメニュー画面の内容が変わる
        - 利用者(user)にはゲストユーザーとログインユーザーで切り替え
        - 飲食店代表者(store_manager)でアクセスsyると飲食店代表者の管理画面が追加表示
        - 管理者(admin)でアクセスすると管理者の管理画面が追加表示

    飲食店への予約機能
      予約カードの時計アイコンから予約情報の変更、x印アイコンから予約情報の削除が可能

    飲食店代表者の作成 (管理者権限)
       飲食店代表者を作成、追加できる

    CSVファイルのインポート機能 (管理者権限)
      admin権限で管理者画面からCSVファイルをインポートして新規飲食店を追加することができる。
        - CSVファイルの内容が適切なである場合のみ新規追加可能
        (CSVファイルの内容については「CSVファイルの記述方法」の部分で確認可能。)

    飲食店情報の追加、編集 (飲食店代表者権限)
      "作成と更新"ページで飲食店の新規追加や各店舗の情報を編集できる


    ユーザーへのお知らせメール機能 (飲食店代表者権限)
      "案内メールの送信"から利用者へメールを送信できる (送信先は複数選択可)

    利用者へ予約日当日の午前9:00にリマインダーメールを送信
      phpコンテナから php artisan reminder:send コマンドでテスト送信可能
      (テスト送信をする際には当日に利用者として予約情報の作成が必要)

    stripe決済
      リマインダーメールの内容に決済リンクがあり、そこからstripeの決済画面にアクセスできる。
        テストモードなので決済時はテスト用のカード情報を入力して決済確認可能。
        - メールアドレス  任意のメールアドレス (例:test@example.com)
        - カード番号  4242 4242 4242 4242
        - 有効期限  任意の将来の月と年 (例: 08/30)
        - CVC: 任意の3桁  (例:123)
        - カード保有者の名前  任意の名前 (例: 山田太郎)

    QRコードで予約情報の確認 (飲食店代表者権限)
      リマインダーメールのQRコードをstore_managerで読み取ると、
      管理画面の予約情報一覧が表示され予約内容を照合できる。

    飲食店に対しての口コミ機能(レビュー)
      飲食店の詳細ページから5段階評価、コメント、イメージ画像の追加が可能
        - ゲストユーザーは口コミの閲覧不可
        - ログインユーザーは口コミの閲覧、投稿、編集、削除が可能
        - 飲食店代表者は口コミの閲覧のみ可能
        - 管理者は口コミの閲覧と全ての口コミに対しての削除が可能


## 使用技術
    Docker 27.1.1
    php 8.3.9
    Laravel 8.83
    Composer 2.7.7
    nginx 1.21.1
    Mysql 8.0.37
    phpMyAdmin 5.2.1
    imagick 3.7.0
    Stripe PHP SDK 15.4.0



## テーブル設計
<img width="650" src="https://github.com/user-attachments/assets/b8dae6cb-0300-4508-b922-a7a1b4837ef8">



## ER図
<img width="650" src="https://github.com/user-attachments/assets/635a3dfe-5f47-4e0c-8465-37d301d472c7">



## dockerビルド
    1 git clone リンク  https://github.com/Okazuma/laravel-mocktest2.git

    2 docker compose up -d --build

    ※ MysqlはOSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlを編集してください。



## Laravelの環境構築
    1 phpコンテナにログイン        $docker compose exec php bash

    2 パッケージのインストール      $composer-install

    3 .envファイルの作成          cp .env.example .env

    4 アプリケーションキーの生成    $php artisan key:generate

    5 マイグレーション            $php artisan migrate

    6 シーディング               $php artisan db:seed

    7 シンボリックリンクの生成     $php artisan storage:link



## メールサーバー設定について
    1 使用しているメールサーバーから必要な設定情報を取得

    2 メールサーバーの情報を.envファイルに設定

    3 .envファイルの変更が反映するようlaravelの設定キャッシュのクリア



## CSVファイルの記述方法
##### CSVファイルの作成ルール
    - 各項目のルールに沿ってキーと値を入力
    - 実際の画像はCSVファイルに含めることができないので別で追加
      (画像については最後に記載)
<img width="500" src="https://github.com/user-attachments/assets/2a36fee5-23d7-4bf9-aa11-83727a69c67a">


##### エクセルやスプレッドシートでのCSVファイル作成方法
    - 1行目に各キーをセルごとに入力する
      「name」「description」「area」「genre」「image_path」

    - 2行目以降に飲食店情報の値をセルごとに入力する
      「飲食店A」「このお店は……」「東京都」「寿司」「storage/images/….jpeg」
<img width="500" src="https://github.com/user-attachments/assets/f2b29d60-dab4-4101-84be-281767cd9145">


##### テキストエディタでの作成方法
    - 1行目に各キーをカンマ区切りで入力する
      name,description,area,genre,image_path

    - 2行目以降に飲食店情報の値をカンマ区切りで入力する
      飲食店A,このお店は……,東京都,寿司,storage/images/….jpeg
<img width="500" src="https://github.com/user-attachments/assets/34ab5a1c-eaec-4192-b4ae-6ef7ba3e3a26">



<!-- ## CSVファイルによる新規店舗の追加 -->
##### 新規飲食店を追加する時のイメージ画像について。
    CSVファイルの「image_path」で画像URLのパスを正しく入力していても、
    画像自体がstorageに存在していなければ新規飲食店を追加できません。
    プロジェクト内に画像が存在しない場合は手動でstorageに画像を追加するか、
    CSVファイルのインポート画面から送信してstorageに追加できます。

    - 画像の形式はjpegとpngのみアップロード可能ですが
      jpgもjpegと同じ種類のデータなので形式をjpgからjpegに書き変えれば
      画像をアップロードすることができます。