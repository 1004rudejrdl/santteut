<?php
/*
=================================================================
+ [DESC] 예약/결제 목록 확인
+ [DATE] 2019-05-26
+ [NAME] 김민지
=================================================================
*/
session_start();
$id=$_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";
$sql=$result=$total_record=$total_pages=$start_record=$row="";
$total_record=0;
$alert = '';

define('ROW_SCALE', 10);
define('PAGE_SCALE', 10);
//r_cancel=0 -> 예약내역
//r_cancel=1 -> 취소내역
$reserve_flag =empty($_POST['reserve_flag']) ? 0 : $_POST['reserve_flag'];
if($reserve_flag){

}
$alert = ($reserve_flag==0) ? "예약 내역이 없습니다." : "취소내역이 없습니다.";

//검색모드
if(isset($_GET["mode"])&&$_GET["mode"]=="search"){
  $year1=$_POST["h_year1"];
  $year2=$_POST["h_year2"];
  $month1=$_POST["h_month1"];
  $month2=$_POST["h_month2"];
  $day1=$_POST["h_day1"];
  $day2=$_POST["h_day2"];

  if($month1>0 && $month1<10){
    $month1="0".$month1;
  }
  if($month2>0 && $month2<10){
    $month2="0".$month2;
  }
  if($day1>0 && $day1<10){
    $day1="0".$day1;
  }
  if($day2>0 && $day2<10){
    $day2="0".$day2;
  }
  $search_start = $year1."-".$month1."-".$day1;
  $search_end = $year2."-".$month2."-".$day2;
  $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `package`.`p_dp_date` between '$search_start' and '$search_end' and `reserve`.`r_id` = '$id' and `reserve`.`r_cancel`='$reserve_flag';";
}else{
  if($id=="admin"){
    $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `reserve`.`r_cancel`='$reserve_flag';";
  }else{
    $sql="SELECT * from `reserve` join `package` on `reserve`.`r_code` = `package`.`p_code` where `reserve`.`r_id` = '$id' and `reserve`.`r_cancel`='$reserve_flag';";
  }

  // 날짜로 검색
  if(isset($_GET['mode'])){
      $date=$_GET['mode'];
      $sql=$sql." where `package`.`p_dp_date` = '$date';";
  }
}

$result=mysqli_query($conn,$sql);
$total_record=mysqli_num_rows($result);
$total_pages=ceil($total_record/ROW_SCALE);
$page=(empty($_GET['page']))?1:$_GET['page'];
if(isset($_POST['page'])){
  $page=(empty($_POST['page']))?1:$_POST['page'];
}

// 현재 블럭의 시작 페이지 = (ceil(현재페이지/블럭당 페이지 제한 수)-1) * 블럭당 페이지 제한 수 +1
//[[  EX) 현재 페이지 5일 때 => ceil(5/3)-1 * 3  +1 =  (2-1)*3 +1 = 4 ]]
$start_page= (ceil($page / PAGE_SCALE ) -1 ) * PAGE_SCALE +1 ;


// 현재페이지 시작번호 계산함.
//[[  EX) 현재 페이지 1일 때 => (1 - 1)*10 -> 0   ]]
//[[  EX) 현재 페이지 5일 때 => (5 - 1)*10 -> 40  ]]
$start_record=($page -1) * ROW_SCALE;


// 현재 블럭 마지막 페이지
// 전체 페이지가 (시작 페이지+페이지 스케일) 보다 크거나 같으면 마지막 페이지는 (시작페이지 + 페이지 스케일) -1 / 아니면 전체페이지 수 .
//[[  EX) 현재 블럭 시작 페이지가 6/ 전체페이지 : 10 -> '10 >= (6+10)' 성립하지 않음 -> 10이 현재블럭의 가장 마지막 페이지 번호  ]]
$end_page= ($total_pages >= ($start_page + PAGE_SCALE)) ? $start_page + PAGE_SCALE-1 : $total_pages;


// 리스트에 보여줄 번호를 최근순으로 부여함.
// 출력될 숫자

?>
<?php
  $now = new DateTime();
  $Y = $now -> format("Y");
  $m = $now -> format("m");
  $d = $now -> format("d");
  //t = the number of days in the given month
  $t = $now -> format("t");


 ?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/reserve/css/reserve_list.css">
    <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
    // 예약내역 취소내역 선택 부분
      $(document).ready(function() {

        $("#reserve_flag").val(<?=json_encode($reserve_flag)?>);
        //여기

        if($("#reserve_flag").val()*1){
          if($("#list_head_cancel").css('background-color')!="white"){
            $("#list_head_cancel").css('background-color', 'white');
            $("#list_head_cancel").css('border', '1px solid #3d3d3d');
            $("#list_head_cancel").css('border-bottom-color', 'white');
            $("#list_head_reserve").css('background-color', '#f2f2f2');
            $("#list_head_reserve").css('border', '1px solid #dedede');
            $("#list_head_reserve").css('border-right-color', '#3d3d3d');
            $("#after").html("취소일");
          }
        }
        //예약내역
        $("#list_head_reserve").click(function(){
          if($("#list_head_reserve").css("background-color")!="white"){
            $("#list_head_reserve").css('background-color', 'white');
            $("#list_head_reserve").css('border', '1px solid #3d3d3d');
            $("#list_head_reserve").css('border-bottom-color', 'white');
            $("#list_head_cancel").css('background-color', '#f2f2f2');
            $("#list_head_cancel").css('border', '1px solid #dedede');
            $("#list_head_reserve").css('border-right-color', '#3d3d3d');
            $("#reserve_flag").val('0');
            document.reserve_flag_form.submit();
          }
        });
        //결제
        $("#list_head_cancel").click(function(){
          if($("#list_head_cancel").css('background-color')!="white"){
            $("#list_head_cancel").css('background-color', 'white');
            $("#list_head_cancel").css('border', '1px solid #3d3d3d');
            $("#list_head_cancel").css('border-bottom-color', 'white');
            $("#list_head_reserve").css('background-color', '#f2f2f2');
            $("#list_head_reserve").css('border', '1px solid #dedede');
            $("#list_head_reserve").css('border-right-color', '#3d3d3d');
            $("#reserve_flag").val('1');
            document.reserve_flag_form.submit();
          }
        });
        //월 클릭 -> days 변화 이벤트
        $("#month1").click(function(event) {
          var days = lastday($("#year1").val(), $(this).val());
          $("#day1").html("");
          for(var i=1; i<=days; i++){
            $("#day1").append("<option value="+i+">"+i+"</option>");
          }
        });
        $("#month2").click(function(event) {
          var days = lastday($("#year2").val(), $(this).val());
          $("#day2").html("");
          for(var i=1; i<=days; i++){
          $("#day2").append("<option value="+i+">"+i+"</option>");
          }
        });
        $("input[name='review_btn']").click(function(event) {
          var popupX = (window.screen.width / 2) - (800 / 2);
          var popupY= (window.screen.height /2) - (500 / 2);
          var r_pk = $(this).attr('id');
          //후기작성 or 후기확인
          var flag = $(this).val();
          var mode = '';
          if(flag !== null){
            switch (flag) {
              case '후기작성':
                mode = 'insert';
                break;
              case '후기확인':
                mode = 'view';
                break;
              default:
                break;
            }
          }
          window.open("../member_review/member_review.php?mode="+mode+"&r_pk="+r_pk, '', 'status=no, width=800, height=500, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
        });
      });
      function lastday(year, month){
        var res = new Date(year, month,0);
        res = res.getDate();
        return res;
      }
    </script>
  </head>
  <body>
    <form name="reserve_flag_form" action="reserve_list.php" method="post">
      <input type="hidden" name="reserve_flag" id="reserve_flag">
    </form>
    <div id="wrap">
    <header><?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?></header>
    <hr>
    <!--예약 리스트 페이지-->
    <div id="reserve_list">
      <h3 id="title" >예약 및 결제 확인</h3>
      <fieldset id="i_field">
        <div id="i"><b>ⓘ</b></div><!-- end of div "i" -->
        <div id="i_div_ul">
          <ul>
            <li>예약코드를 클릭하시면 예약상세 페이지 확인이 가능하시며, 개별상품별 결제가 가능합니다.</li>
            <li>미결제로 취소된 예약 건의 경우 취소일로부터 3개월 경과 시 조회되지 않습니다.</li>
            <li>안내사항3</li>
            <li>안내사항4</li>
          </ul>
        </div>
      </fieldset>
      <br>
      <fieldset id="search_field">
        <span id="search_date">출발일</span>&nbsp;&nbsp;&nbsp;
        <select class="date_select" name="year1" id="year1" >
        <?php
          // 현재 연도 +- 2
          for ($i=$Y+2; $i > $Y-2 ; $i--) {
            if($i==$Y){
              echo '<option value="'.$i.'" selected >'.$i.'</option>';
            }else {
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
          }
        ?>
        </select>년
        <select class="date_select" name="month1" id="month1">
          <?php
            // MONTH
            for ($i=1; $i <= 12 ; $i++) {
              if($i==$m){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>월

        <select class="date_select" name="day1" id="day1">
          <?php
            // DAYS
            for ($i=1; $i <= $t ; $i++) {
              if($i==$d){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>일
        &nbsp;~&nbsp;

        <select class="date_select" name="year2" id="year2" >
        <?php
          // 현재 연도 +- 2
          for ($i=$Y+2; $i > $Y-2 ; $i--) {
            if($i==$Y){
              echo '<option value="'.$i.'" selected >'.$i.'</option>';
            }else {
              echo '<option value="'.$i.'">'.$i.'</option>';
            }
          }
        ?>
        </select>년
        <select class="date_select" name="month2" id="month2">
          <?php
            // MONTH
            for ($i=1; $i <= 12 ; $i++) {
              if($i==$m){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>월
        <select class="date_select" name="day2" id="day2" >
          <?php
            // DAYS
            for ($i=1; $i <= $t ; $i++) {
              if($i==$d){
                echo '<option value="'.$i.'" selected >'.$i.'</option>';
              }else {
                echo '<option value="'.$i.'">'.$i.'</option>';
              }
            }
          ?>
        </select>일
          &nbsp;&nbsp;
        <input type="button" id="search_btn" name="" onclick="reserve_search_submit()" value="검색하기" >
      </fieldset>
      <form name="reserve_search_form" action="reserve_list.php?mode=search" method="post">
      <input type="hidden" name="h_year1" id="h_year1" value="">
      <input type="hidden" name="h_year2" id="h_year2" value="">
      <input type="hidden" name="h_month1" id="h_month1" value="">
      <input type="hidden" name="h_month2" id="h_month2" value="">
      <input type="hidden" name="h_day1" id="h_day1" value="">
      <input type="hidden" name="h_day2" id="h_day2" value="">
      </form>

      <script type="text/javascript">
        function reserve_search_submit(){
          var year1 = document.getElementById('year1');
          var year2 = document.getElementById('year2');
          var month1 = document.getElementById('month1');
          var month2 = document.getElementById('month2');
          var day1 = document.getElementById('day1');
          var day2 = document.getElementById('day2');

          var h_year1 = document.getElementById('h_year1');
          var h_year2 = document.getElementById('h_year2');
          var h_month1 = document.getElementById('h_month1');
          var h_month2 = document.getElementById('h_month2');
          var h_day1 = document.getElementById('h_day1');
          var h_day2 = document.getElementById('h_day2');

          h_year1.value = year1.value;
          h_year2.value = year2.value;
          h_month1.value = month1.value;
          h_month2.value = month2.value;
          h_day1.value = day1.value;
          h_day2.value = day2.value;

          alert(h_year1.value);

          document.reserve_search_form.submit();
        }

        function cancel(mode,pk){
          var result=confirm("삭제하시겠습니까?");
          if(result){
            window.location.href="reserve_list_query.php?r_pk="+pk+"&mode="+mode;
          }
        }

      </script>
      <br><br>
      <fieldset id="list_field" >
         <h4 id="sub_title"><b class="symbol_greater_than">></b>산뜻 예약/결제</h4>
        <table id="list_tbl_head"><tr><td id="list_head_reserve">예약내역</td><td id="list_head_cancel">취소내역</td></tr></table>

        <table id="list_tbl_body">
          <?php
          if($id=="admin"){
            echo '<tr>
              <td>예약날짜</td>
              <td>예약코드</td>
              <td>상품명</td>
              <td>총 결제금액</td>
              <td>인원(ID)</td>
              <td>출발일/귀국일</td>
              <td>예약/결제상태</td>
              <td>취소</td>
              <td id="after">후기</td>
            </tr>';
          }else{
            echo '<tr>
              <td>예약날짜</td>
              <td>예약코드</td>
              <td>상품명</td>
              <td>총 결제금액</td>
              <td>인원</td>
              <td>출발일/귀국일</td>
              <td>예약/결제상태</td>
              <td>취소</td>
              <td id="after">후기</td>
            </tr>';
          }
          ?>

          <output id="list_tbl_body_output">
            <?php
            mysqli_data_seek($result,$start_record);
            for ($record = $start_record; $record  < $start_record+ROW_SCALE && $record<$total_record; $record++){
              $row=mysqli_fetch_array($result);
              //예약날짜/ 예약 코드/ 상품명/ 총 결제금액/ 인원/ 출발일*귀국일 / 예약/결제상태 /취소 / 후기
              //예약 pk 저장
              $r_pk = $row['r_pk'];
              $id = $_SESSION['id'];
              $r_id = $row['r_id'];
              $r_date = $row['r_date'];
              $r_code=$row['r_code'];
              $r_cancel=$row['r_cancel'];
              $r_cancel_date=$row['r_cancel_date'];
              //상품명
              $p_name=$row['p_name'];
              //총 결제금액(결제 해야할 금액 - reserve.r_pay)
              $r_pay=$row['r_pay'];
              //인원
              $r_adult=$row['r_adult'];

              $r_kid=$row['r_kid'];
              $r_baby=$row['r_baby'];
              $r_total = $r_adult + $r_kid + $r_baby;
              //출발일/귀국일
              $p_dp_date=$row['p_dp_date'];
              $p_period=$row['p_period'];
              $timestamp = strtotime("$p_dp_date +$p_period days");
              $p_arr_date1 = date('y-m-d', $timestamp);
              $p_arr_date2 = "20".$p_arr_date1;
              //예약상태
              //총 상품금액
              $b_pay=$row['b_pay'];

              // $b_pay=$bill_row['b_pay'];

              $p_pay=$row['p_pay'];
              //후기

              $reserve_status_sql = "SELECT sum(`r_adult`+`r_kid`+`r_baby`),`p_bus` from `package` inner join `reserve` on `package`.`p_code` = `reserve`.`r_code` where `reserve`.`r_code` = '$r_code';";
              $result_status_sql=mysqli_query($conn,$reserve_status_sql);
              $total=0;
              $status="";
              for($i=0;$i<mysqli_num_rows($result_status_sql);$i++){
                $row1 = mysqli_fetch_array($result_status_sql);
                $sum = $row1['sum(`r_adult`+`r_kid`+`r_baby`)'];
                $p_bus = $row1['p_bus'];
                $p_bus_half =(ceil($p_bus / 2));
                $total+=$sum;
              }

              if($id=="admin"){
                $bill_sql = "SELECT * FROM `bill` where `b_code`='$r_code' and `b_pk`='$r_pk';";
              }else{
                $bill_sql = "SELECT * FROM `bill` where `b_code`='$r_code' and `b_pk`='$r_pk' and `b_id`='$id';";
              }

              //결제상태
              $bill_result=mysqli_query($conn,$bill_sql);
              $count=mysqli_num_rows($bill_result);
              $bill_row=mysqli_fetch_array($bill_result);

              if($total<$p_bus_half){
                $status="예약완료";
                $cancel_status = '<input type="button" onclick="cancel(\'update\',\''.$r_pk.'\')" name="cancel_btn" id="'.$r_pk.'" value="취소">';
              }


              if($total>=$p_bus_half){
                if($count!=0){
                  $status = "<p style='color:green;'>결제완료</p>";
                  $cancel_status = '<input type="button" onclick="cancel(\'delete\',\''.$r_pk.'\')" name="cancel_btn" id="'.$r_pk.'" value="취소">';
                }else{
                  $status="<a style='color:red;' href='../bill/bill_view.php?&r_pk=$r_pk'>결제대기</a>";
                  $cancel_status = '<input type="button" onclick="cancel(\'update\',\''.$r_pk.'\')" name="cancel_btn" id="'.$r_pk.'" value="취소">';
                }

              }

              //산행후기 review @@@@@@@@@MINJI0527
              $review_sql = "SELECT * FROM `member_review` where `r_pk`='$r_pk'";
              //취소
              $review_result=mysqli_query($conn,$review_sql);
              $review_row=mysqli_fetch_array($review_result);

              //해당 예약 항목의 후기 여부 확인 -> 후기 없으면 작성 form /있으면 보여주기
              $review_status =$review_row['num'];
              // $r_pk = "aaa";
              if(empty(mysqli_num_rows($review_result))){
                // $review_status='<button type="button" name="button" onclick="review("../member_review/member_review.php");" >후기작성</button>';
                $review_status='<input type="button" name="review_btn" id="'.$r_pk.'" value="후기작성">';
              }else{
                $review_status='<input type="button" name="review_btn" id="'.$r_pk.'" value="후기확인">';
              }


              if($r_cancel=="1"){
                $status="예약취소";
                if($count=="0"){
                  $cancel_status = "<p style='color:red;'>취소완료</p>";
                }
                $review_status =$r_cancel_date;
              }


             ?>

             <?php
             if($id=="admin"){
               echo '<tr>
                 <td>'.$r_date.'</td >
                 <td><a href="../package/package_view.php?mode='.$r_code.'">'.$r_code.'</a></td>
                 <td>'.$p_name.'</td>
                 <td>'.$r_pay.'</td>
                 <td>'.$r_total.'명<br>('.$r_id.')</td>
                 <td>'.$p_dp_date.'<br>'.$p_arr_date2.'</td>

                 <td>'.$status.'</td>
                 <td> '.$cancel_status.' </td>

                 <td>'.$review_status.'</td>
               </tr>';
             }else{
               echo '<tr>
                 <td>'.$r_date.'</td >
                 <td><a href="../package/package_view.php?mode='.$r_code.'">'.$r_code.'</a></td>
                 <td>'.$p_name.'</td>
                 <td>'.$r_pay.'</td>
                 <td>'.$r_total.'</td>
                 <td>'.$p_dp_date.'<br>'.$p_arr_date2.'</td>

                 <td>'.$status.'</td>
                 <td> '.$cancel_status.' </td>

                 <td>'.$review_status.'</td>
               </tr>';
             }

               }
              ?>

          </output>
        </table>
      </fieldset>
      <?php
      if(empty($total_record)){
        echo '<p id="no_result" style="text-align:center; padding:2%;margin-bottom:3%;">'.$alert.'</p><hr><br>';
      }

       ?>
    </div> <!-- end of div "reserve_list" -->
    <footer> <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?> </footer>
    </div>  <!-- end of div "wrap" -->
  </body>
</html>
