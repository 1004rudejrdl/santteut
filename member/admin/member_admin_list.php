<!-- =================================================================
// + [DESC] 회원관리 list총괄
// + [DATE] 2019-05-26
// + [NAME] 이우주
// ================================================================= -->

<?php
session_start();

if(!(isset($_SESSION['id']) &&  $_SESSION['id']=="admin")){
  echo "<script>alert('권한없음!');history.go(-1);</script>";
  exit;
}

$name = $_SESSION['name'];

//0-0. 인클루드 디비
include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/db_connector.php";

//1. 게시물수 정의
define('ROW_SCALE', 10);
define('PAGE_SCALE', 5);

//2. 변수정의
// $view_num 보여지는번호, $num은 DB에서 프라이머리키 번호
// $total_record 전체 게시물수, $start_record 한 페이지의 처음 게시물
// $record 는 게시물1개, $total_pages는 전체 페이지를 의미
$sql=$result=$total_record=$total_pages=$start_record=$row="";
$total_record=0;

//3. 검색모드를 세팅()
if(isset($_GET["mode"])&&$_GET["mode"]=="search"){

  // find_option 는 select의 값들 문자열로 받아옴
  $find_option = test_input($_POST["find_option"]);

  // find_input 는 input의 값을 문자열로 받아옴
  $find_input = test_input($_POST["find_input"]);
  $q_find_input = mysqli_real_escape_string($conn, $find_input);

  if(empty($find_input)){
    echo ("<script>window.alert('검색할 단어를 입력해 주세요')history.go(-1)</script>");
    exit;
  }

  $sql="SELECT id, name, address1, address2, hp1, hp2, email from `member` where $find_option like '%$q_find_input%';";
}else{
  $sql="SELECT id, name, address1, address2, hp1, hp2, email from `member`";
}

// 쿼리문실행문장
$result=mysqli_query($conn,$sql);

$total_record=mysqli_num_rows($result);

// 조건?참:거짓
$total_pages=ceil($total_record/ROW_SCALE);

// 페이지가 없으면 디폴트 페이지 1페이지
// if(empty($_GET['page'])){$page=1; }else{ $page=$_GET['page']; }
$page=(empty($_GET['page']))?1:$_GET['page'];

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
$view_num = $total_record - $start_record;

?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/member/admin/css/member_admin_list.css?ver=0">
    <script type="text/javascript" src="./js/member_admin_del.js?ver=1"></script>

    <title>회원관리</title>
  </head>
  <body>
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <br><br><br>
    <section id="notice">

      <form name="notice_form" action="notice_list?mode=search" method="post">
      <div class="notice_list_search">
        <select>
          <option value="">아이디</option>
          <option value="">이름</option>
          <option value="">이메일</option>
        </select>
        <input type="text" name="" value="">
        <button type="button" name="button">검색</button>
      </div>
      </form>

      <!--총 회원수-->
      <div class="total_title">
        <h4>총 <?=$total_record?> 명</h4>
      </div>

      <!--게시물 제목-->
      <script type="text/javascript">
        function delete_submit(){
          var check = document.getElementsByName('select_del');
          var del_value = '';
          for (var i = 0; i < check.length; i++) {

            // check가 되어있으면 삭제
            // check된 체크박스의  value = id
            if(check[i].checked){
              // 체크된 아이디들의  배열 생성
              // ex) admin/wooju00/minji/
              del_value += check[i].value +"/";
            }
          }
          // member_admin_query.php 로 넘기기 위한 작업
          document.getElementsByName('del_value')[0].value = del_value;
          document.del_form.submit();
        }
      </script>
      <form name="del_form" action="member_admin_query.php?mode=delete" method="post">
        <!-- delete 하고 싶은 멤버들 -->
        <input type="hidden" name="del_value" value="">
      <table id="list_tbl" border="1">
        <tr>
          <th>선택</th>
          <th>아이디</th>
          <th>이름</th>
          <th>주소1</th>
          <th>주소2</th>
          <th>일반전화</th>
          <th>휴대폰번호</th>
          <th>이메일</th>
        </tr>

      <!--게시물 내용-->
      <?php
        for ($record = $start_record; $record  < $start_record+ROW_SCALE && $record<$total_record; $record++){
          mysqli_data_seek($result,$record);
          $row=mysqli_fetch_array($result);
          $view_num=$row['num'];
          $id=$row['id'];
          $name=$row['name'];
          $address1=$row['address1'];
          $address2=$row['address2'];
          $hp1=$row['hp1'];
          $hp2=$row['hp2'];
          $email=$row['email'];
      ?>

        <tr>
          <!--번호-->
          <td> <input type="checkbox" id="" name="select_del" value="<?=$id?>"> </td>
          <td><?=$id?></td>
          <td><?=$name?></td>
          <td><?=$address1?></td>
          <td><?=$address2?></td>
          <td><?=$hp1?></td>
          <td><?=$hp2?></td>
          <td><?=$email?></td>
        </tr>
        <?php
          $view_num--;
         }//end of for
        ?>
      </table>

<br><br>

<?php
if(!empty($_SESSION['id'])){
  echo ('<a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/join/join_member.php" class="hov"><button id="admin_write_btn" type="button" name="button">
  회원등록</button></a>');
  echo ('<a href="http://'.$_SERVER['HTTP_HOST'].'/santteut/member/join/join_edit.php" class="hov"><button id="admin_write_btn" type="button" name="button">
  회원정보수정</button></a>');
  echo ('<button id="admin_write_btn" onclick="delete_submit()" type="button" name="button">
  회원삭제</button>');

}

?>
</form>
<br>
<!--$page 는 현재페이지를 의미 x / 각 페이지를 의미-->
      <div class="page_button_group">
        <?php
        //현재 블럭의 시작 페이지가 페이지 스케일 보다 클 때 -> 처음으로 버튼 생성 + 이전 블럭 존재
        //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
        if( $start_page > PAGE_SCALE ){
          // echo( '<a href='member_admin_list.php?page=1'> << </a>' );
          echo( '<a href="member_admin_list.php?page=1"><button type="button" name="button" title="처음으로"><<</button></a>' );

          // 이전 블럭 클릭 시 -> 현재 블럭의 시작 페이지 - 페이지 스케일
          // 현재 6 page 인 경우 '<(이전블럭)' 클릭 -> $pre_page = 6-PAGE_SCALE  -> 1 페이지로 이동
          $pre_block= $start_page - PAGE_SCALE;
          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="member_admin_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }else{
            echo( '<a href="member_admin_list.php?page='.$pre_block.'"><button type="button" name="button" title="이전"><</button></a>' );
          }
        }

        //현재 블럭에 해당하는 페이지 나열
        for( $i = $start_page; $i <= $end_page; $i++ ){
            //현재 블럭에 현재 페이지인 버튼
            if ( $i == $page ){
              echo( '<a href="#"><button type="button" name="button" style="background-color: #2F9D27; border: 1px solid #2F9D27; color: white;">'.$i.'</button></a>' );
            }else if(isset($_GET['mode']) && $_GET['mode']=="search"){
              echo( '<a href="qna_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }else{
              echo( '<a href="qna_list.php?page='.$i.'"><button type="button" name="button">'.$i.'</button></a>' );
            }
        }

        // 현재 블럭의 마지막 페이지 보다 총 페이지 수가 큰 경우, >(다음) 버튼 / >>(맨끝으로) 버튼 생성
        //[ex]  page가 9개 있고 현재 페이지가 6페이지인 경우  / 12345/ 6789     =>  <<(처음으로) <(이전) 6 7 8 9
        //[ex]  page가 9개 있고 현재 페이지가 1페이지인 경우  / 12345/ 6789     =>  1 2 3 4 5 >(다음) >>(맨끝으로)
        if( $total_pages > $end_page ){
          // 다음블럭 => 현재 블럭의 시작페이지 + 스케일
          // 클릭 시 다음 블럭의 첫 번째 페이지로 이동
          // [ex]  총 page 9개 있고 페이지가 3인  경우 / >(다음) 버튼 누르면 '6'으로 이동
          $next_block= $start_page + PAGE_SCALE;

          if(isset($_GET['mode']) && $_GET['mode']=="search"){
            echo( '<a href="member_admin_list.php?mode=search&find_option=$find_option&find_input=$find_input&page='.$next_block.'"><button type="button" name="button">></button></a>' );
          }else{
            echo( '<a href="member_admin_list.php?page='.$next_block.'"><button type="button" name="button" title="다음">></button></a>' );
          }

          //맨끝페이지로 이동
          echo( '<a href="member_admin_list.php?page='.$total_pages.'"><button type="button" name="button" title="맨끝으로">>></button></a>' );
        }
        ?>
      </div>
    </section>

  <footer>
    <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
  </footer>
  </body>
</html>
