<?php
require_once(dirname(__FILE__) . "/../dbconnect.php");
require_once(dirname(__FILE__) . "/../controllers/adminLoginGetController.php");
session_start();

$stmt = $db->query('SELECT events.id, events.name, events.start_at, events.end_at, count(event_user_attendance.id) AS total_participants FROM events LEFT JOIN event_user_attendance ON events.id = event_user_attendance.event_id WHERE events.start_at >= DATE(now()) and event_user_attendance.attendance_status=1 GROUP BY events.id ORDER BY events.start_at ASC');
$events = $stmt->fetchAll();

function get_day_of_week($w)
{
  $day_of_week_list = ['日', '月', '火', '水', '木', '金', '土'];
  return $day_of_week_list["$w"];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <title>Schedule | POSSE</title>
</head>

<body>
  <header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
      <div class="h-full">
        <img src="../img/header-logo.png" alt="" class="h-full">
      </div>
      <div class="flex">
        <form action="../controllers/logoutPostController.php" method="POST">
          <input value="ログアウト" type="submit" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200 text-xs">
        </form>
        <a href="/" class="text-xs text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">ユーザー画面</a>
      </div>
    </div>
  </header>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">
      <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">メニュー</h2>
        <div class="flex">
          <a href="" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-blue-600 text-white">イベントリスト</a>
          <a href="./userRegister.php" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-white">ユーザー登録</a>
          <a href="./eventRegister.php" class="px-3 py-2 text-xs font-bold mr-2 rounded-md shadow-md bg-white">イベント追加</a>
        </div>
      </div>
      <div id="events-list">
        <div class="flex justify-between items-center mb-3">
          <h2 class="text-sm font-bold">一覧</h2>
          <div class="text-xs font-bold p-2 bg-white rounded-sm">
            <a href="" class="px-2 py-1 bg-blue-600 text-white mr-2 rounded-sm">カード</a>
            <a href="" class="text-gray-400">カレンダー</a>
          </div>
        </div>

        <?php foreach ($events as $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
          ?>
          <div class="admin-modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event_<?php echo $event['id']; ?>">
            <div>
              <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
              <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
              <p class="text-xs text-gray-600">
                <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
              </p>
            </div>
            <div class="flex flex-col justify-between text-right">
              <p class="text-sm"><span class="text-xl"><?php echo $event['total_participants']; ?></span>人参加 ></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

    <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
      <div class="modal-content text-left py-6 pl-10 pr-6">
        <div class="z-50 text-right mb-5">
          <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
        </div>

        <form action="../controllers/updateEventPostController.php" method="POST" id="modalInner"></form>

      </div>
    </div>
  </div>

  <script src="/js/main.js"></script>
  <script id="toggle_script"></script>
</body>

</html>