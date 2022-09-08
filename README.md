# posse1-hackathon-202209-team2D
### 注意
なるべくIssuesとPull requestsがDevelopmentの機能で紐づくようにしましたが一部ミスでコメントで紐付けをおこなっています。ですので、コメントもご確認ください。

### クローン
git clone https://github.com/posse-ap/posse1-hackathon-202209-team2D.git

### ビルド

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

### 動作確認

ブラウザで `http://localhost:8080/auth/login/index.php` にアクセスして、正しく画面が表示されているか確認してください

初期データ
管理画面はuser0@gmail.comにのみあります。
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

### メール・スラックについて

## メール送信
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
```
（メンターさんは我々のワークスペースに入っていないためPRの画面でご確認ください）

