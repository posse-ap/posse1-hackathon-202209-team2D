# posse1-hackathon-202209-team2D
### 注意
なるべくIssuesとPull requestsがDevelopmentの機能で紐づくようにしましたが一部ミスでコメントで紐付けをおこなっています。ですので、コメント（クローズのログのリンク先）もご確認ください。

### クローン
```bash
git clone https://github.com/posse-ap/posse1-hackathon-202209-team2D.git
```

### ビルド

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

## ダミーデータ登録

```bash
docker ps
docker exec -it [mysqlコンテナ]　bash
mysql -u root -p < /docker-entrypoint-initdb.d/init.sql
```

### 動作確認

ブラウザで `http://localhost:8080/auth/login/index.php` にアクセスして、正しく画面が表示されているか確認してください

## ログイン
初期データ（管理者権限はuser0@gmail.comにのみあります。）
```bash
email:user0@gmail.com
pass:password0
email:user1@gmail.com
pass:password1
email:user2@gmail.com
pass:password2
email:user3@gmail.com
pass:password3
```

## 管理画面からイベント登録
管理者権限を持つアカウントでログイン後、管理者画面へ行きます。イベント追加を押し、フォームに記入に記入します。開催日時は入力日時より後、終了日時は開催日より後にしてください。
その後、ユーザー画面に遷移して、未回答のセクションから、追加したイベントがあることを確認してください。

## ユーザー画面でのイベント参加登録
そのイベントをクリックしてモーダルを開くと、モーダルが出るので、参加するを押してください。その後、参加のセクションから参加登録したイベントがあることを確認してください。


### メール・スラックについて

## メール送信のバッジ
```bash
docker ps
docker exec -it [phpのコンテナid] bash
```
srcの中にある適切なphpファイルを選択


メールを一日前に全員に
```bash
php mail_1day_ago_all.php
```
メールを１日前に参加者に
```bash
php mail_1day_ago_participant.php
```
メールを三日前に全員に
```bash
php mail_3days_ago_all.php
```
メールを三日前に未回答者に
```bash
php mail_3days_ago_not_answer.php
```
スラックを１日前に参加者に
```bash
php slack_1day_ago_participant.php
```
スラックを三日前に未回答者に
```bash
php slack_3days_ago_not_answer.php
```
で実行。

## メール確認

ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます

## スラック通知
```bash
ワークスペース：2Dhack
チャンネル:2d-hack
発言するApp:event-notification-app
```
（メンターさんは我々のワークスペースに入っていないためPRの画面でご確認ください。トークンを変数で小分けにすることで、トークンの無効化を回避していますので、トークンは公開しないでください。ご了承ください。)


