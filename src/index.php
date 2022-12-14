<?php
require('dbconnect.php');
require './controllers/loginGetController.php';
require './controllers/eventsGetController.php';
session_start();

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
        <img src="img/header-logo.png" alt="" class="h-full">
      </div>
      <div class="flex">
        <form action="./controllers/logoutPostController.php" method="POST">
          <input value="ログアウト" type="submit" class="mr-2 text-xs text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">
        </form>
        <?php
        if ($_SESSION['login_user']['is_admin']) {
          echo '<a href="./admin/admin.php" class="text-xs text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">管理者画面</a>';
        }
        ?>
      </div>
    </div>
  </header>

  <main class="bg-gray-100">
    <div class="w-full mx-auto p-5">
      <div id="filter" class="mb-8">
        <h2 class="text-sm font-bold mb-3">フィルター</h2>
        <div class="flex">
          <a href="index.php" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?php if (!isset($_GET['attendance_status'])) {
                                                                                              echo 'bg-blue-600 text-white';
                                                                                            } else {
                                                                                              echo 'bg-white';
                                                                                            } ?>">全て</a>
          <a href="index.php?attendance_status=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?php if ($_GET['attendance_status'] == 1) {
                                                                                                                  echo 'bg-blue-600 text-white';
                                                                                                                } else {
                                                                                                                  echo 'bg-white';
                                                                                                                } ?>">参加</a>
          <a href="index.php?attendance_status=2" class="buttons_to_change_attendance_filter px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?php if ($_GET['attendance_status'] == 2) {
                                                                                                                                                      echo 'bg-blue-600 text-white';
                                                                                                                                                    } else {
                                                                                                                                                      echo 'bg-white';
                                                                                                                                                    } ?>">不参加</a>
          <a href="index.php?attendance_status=0" class="buttons_to_change_attendance_filter px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md <?php if ($_GET['attendance_status'] == 0 && isset($_GET['attendance_status'])) {
                                                                                                                                                      echo 'bg-blue-600 text-white';
                                                                                                                                                    } elseif ($_GET['attendance_status'] != 0 && isset($_GET['attendance_status'])) {
                                                                                                                                                      echo 'bg-white';
                                                                                                                                                    } ?>">未回答</a>
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

        <?php foreach ($events_filtered_by_login_user_attendance_status as $event_id => $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = get_day_of_week(date("w", $start_date));
          ?>
          <div class="bg-white mb-3 p-4 shadow-md rounded-md">
            <div class="modal-open flex justify-between cursor-pointer" id="event_<?php echo $event_id; ?>">
              <div>
                <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
                <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
                <p class="text-xs text-gray-600">
                  <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
                </p>
              </div>
              <div class="flex flex-col justify-between text-right">
                <div>
                  <?php if ($event['login_user_attendance_status'] == 0) : ?>
                    <p class="text-sm font-bold text-yellow-400">未回答</p>
                    <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime('-3 day', $start_date)); ?></p>
                  <?php elseif ($event['login_user_attendance_status'] == 2) : ?>
                    <p class="text-sm font-bold text-gray-300">不参加</p>
                  <?php elseif ($event['login_user_attendance_status'] == 1) : ?>
                    <p class="text-sm font-bold text-green-400">参加</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <p id="show_participants_<?php echo $event_id; ?>" class="text-sm show_participants"><span class="text-xl">
                <?php
                if (isset($event['attendance_status'][1])) {
                  echo count($event['attendance_status'][1]);
                } else {
                  echo 0;
                }
                ?></span>人参加 ></p>
            <div class="hidden" id="participants_<?php echo $event_id; ?>">
              <p>参加者一覧</p>
              <div>
                <?php
                foreach ($event['attendance_status'][1] as $participant) {
                  echo '・' . $participant['user_name'] . '<br>';
                }
                ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php
      include_once(dirname(__FILE__) . "/pagination/footer.php");
      ?>
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

        <div id="modalInner">
        </div>

      </div>
    </div>
  </div>

  <script src="/js/main.js"></script>
  <script id="toggle_script"></script>
</body>

</html>