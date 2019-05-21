<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/common/css/login_menu.css?ver=6">
    <link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/santteut/tour/reserve/css/reserve_view.css?ver=0.1">

    <title>산뜻 :: 즐거운 산행</title>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
  <script type="text/javascript">
  var a=450;
  var b=0;
  var c=1;
  var scroll_count =0;
      var prevScrollpos = window.pageYOffset;
      window.onscroll = function() {

      var currentScrollPos = window.pageYOffset;
        if(window.scrollY<=600){
        if (prevScrollpos > currentScrollPos) {
          move_sidebar_2();
        } else {
          if(a<650){
            move_sidebar();
          }

        }
        prevScrollpos = currentScrollPos;
      }
      }
    function move_sidebar(){
      a=a+10;
      c=c+10;
      var d=c+"px";
      var b =a+"px";
        $("#reserve_detail_menu").css('height', b);
        $("#reserve_finish").css('margin-top', d);
        // $("#reserve_button").css('padding-bottom', '20px');
    }
    function move_sidebar_2(){
      a=a-10;
      c=c-10;
      var d=c+"px";
      var b =a+"px";
      if(a>450){
        $("#reserve_detail_menu").css('height', b);
        $("#reserve_detail_menu").css('min-height', '430px');
        $("#reserve_finish").css('margin-top', d);
          // $("#reserve_button").css('padding-bottom', '20px');
        // $("#reserve_button").css('margin-bottom', '20px');

      }

        // alert(b);

    }
    $(document).ready(function() {

      if($("#last_seat").val()=="28"){
        $("#seat_box").css('margin-left', '200px');
        $("#seat_box").css('padding-top', '35px');

      }else{
        $("#seat_box").css('margin-left', '160px');
        $("#seat_box").css('padding-top', '30px');
      }


    });
  </script>

  </head>

  <body>
    <!--로그인 회원가입 로그아웃-->
    <div id="wrap">
    <header>
      <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/login_menu.php";?>
    </header>
    <div id="middle2">

    <div id="top_text"><b>예약하기</b></div>
    <div id="tbl_div1">
      <div id="top_text2"><b>선택 상품정보</b></div>
      <table id="tbl1">
        <tr>
          <td class="left2" id="pac_name" >상품명</td>
          <td id="pac_name2">백두산이다아아아아아아아이야아아아아아앙</td>
        </tr>

        <tr>
          <td class="left2" id="pac_code">상품코드</td>
          <td id="pac_code2">ABC123455</td>
        </tr>
        <tr>
          <td rowspan="3" class="left2" id="sch1">일정</td>
          <td id="period1">6일</td>
        </tr>

        <tr>
          <td id="go"><div class="gb2">한국출발</div> </td>

        </tr>

        <tr>
          <td id="back"><div class="gb2" >한국도착</div> </td>

        </tr>
      </table>
    </div>

    <div id="tbl_div2">
      <div id="top_text3"><b>예약자 정보</b></div>
      <table id="tbl2">
        <tr>
          <td class="left2" id="res_name1">예약자명<p class="star">*</p></td>
          <td id="res_name_td"> <input type="text" id="res_name" value=""> </td>
          <td class="left2" id="res_phone1">휴대폰번호<p class="star">*</p></td>
          <td id="res_phone_td"> <input type="text" id="res_phone" value="" placeholder="  '-' 없이 입력해주세요"> </td>
        </tr>

        <tr>
          <td class="left2" id="res_email0">이메일<p class="star">*</p></td>
          <td colspan="3" > <input type="text" id="res_email1" value=""> @
            <select id="res_email2" name="">
            <option value="">선택</option>
            <option value="">naver.com</option>
            <option value="">hanmail.net</option>
            <option value="">google.com</option>
            <option value="">nate.com</option>
          </select> </td>

        </tr>
      </table>
    </div>

    <div id="tbl_div3">
      <div id="tour_text1"><b>여행자 정보</b></div>
      <div id="tour_text2">  <b class="label_img">></b>  <b id="sel_text">인원선택</b> </div>
      <table id="tbl3">
        <tr>
          <td class="left3">성인<br>(만 12세 이상)</td>
          <td>
            <div class="count"><button type="button" class="minus"><span class="ir">-</span></button><input type="text" value="1" class="in1"><button type="button" class="plus"><span class="ir">+</span></button>
            </div>
          </td>
          <td class="left3">아동<br>(만 12세 미만)</td>
          <td>
            <div class="count"><button type="button" class="minus"><span class="ir">-</span></button><input type="text" value="1" class="in1"><button type="button" class="plus"><span class="ir">+</span></button>
            </div>
          </td>
          <td class="left3">유아<br>(만 2세 미만)</td>
          <td>
            <div class="count"><button type="button" class="minus"><span class="ir">-</span></button><input type="text" value="1" class="in1"><button type="button" class="plus"><span class="ir">+</span></button>
            </div>
          </td>
        </tr>
      </table>

      <div id="check_eql">
        <input type="checkbox" id="box1"><p>성인1이 예약자와 동일</p>
      </div>

      <table id="tbl4">
        <tr>
          <td class="left4">한글이름<p class="star">*</p></td>
          <td class="left4">영문성<p class="star">*</p></td>
          <td class="left4">영문이름<p class="star">*</p></td>
          <td class="left4">성별<p class="star">*</p></td>
          <td class="left4">법정생년월일<p class="star">*</p></td>
          <td class="left4">휴대폰번호<p class="star">*</p></td>
        </tr>
        <tr>
          <td class="inputs"> <b>성인1</b> <input type="text" class="inputs1" id="input1" value=""> </td>
          <td class="inputs"> <input type="text" class="inputs1" value=""> </td>
          <td class="inputs"> <input type="text" class="inputs1" value=""> </td>
          <td class="inputs"> <input type="radio" name="gen" id="male" value=""><label for="">남&nbsp;</label><input type="radio" name="gen" value=""><label for="">여</label></td>
          <td class="inputs"> <input type="text" id="inputs2" value=""> </td>
          <td class="inputs"> <input type="text" id="phone_num" value=""> </td>
        </tr>
      </table>
    </div>

      <div id="tour_text3">  <b class="label_img">></b>  <b id="sel_seat">좌석선택</b> </div>
      <!-- <img src="img/bus.jpg" alt="" id="bus_form"> -->
      <div id="bus_seat">
        <div id="seat_box">
        <?php
        //우등버스인지 일반버스인지 넘겨주는 값
        $bus="2";
        if($bus==="1"){
          define('row', 2);
          define('col', 8);
          define('margin', 322);
          define('last', 28);
        }else{
          define('row', 3);
          define('col', 9);
          define('margin', 375);
          define('last', 41);
        }

        //****************************버스 좌석 생성
      for ($i=0; $i <=row ; $i++) {
        for ($j=0; $j <=col ; $j++) {
            echo '<input type="checkbox" value="'.((row+1)*$j+$i+1).'">'.((row+1)*$j+$i+1);
            echo "&nbsp;";
            if($j==col){
              echo "<br>";
              if($i==1){
                echo '<input type="checkbox" id="last_seat" style="margin-left:'.margin.'px; margin-top:15px; margin-bottom:15px;" value="'.last.'">'.last.'<br>';
              }
            }else if(((row+1)*$j+$i+1)==9 && !($bus=="1")){
               echo "&nbsp;&nbsp;";
            }
          }
        }

        ?>
        </div>


        <div id="terms_view">
          <div id="all_agree">
            <input type="radio" name="all_choice_value" value="" onclick="all_choice_value()">전체동의하기
            <script type="text/javascript">
              function all_choice_value(){
                var h_y= document.getElementById('h_y');
                var n_y= document.getElementById('n_y');
                var c_y= document.getElementById('c_y');
                var a_y= document.getElementById('a_y');
                h_y.checked=true;
                n_y.checked=true;
                c_y.checked=true;
                a_y.checked=true;
              }
            </script>
          </div>
        <div id="term_btn">
          <button class="tablink" onclick="openPage('Home', this,'#bdbdbd','Home_choice_value')" id="defaultOpen">여행표준약관</button>
          <button  class="tablink" onclick="openPage('News', this,'#bdbdbd','News_choice_value')" >위치기반 서비스 동의</button>
          <button class="tablink"  onclick="openPage('Contact', this,'#bdbdbd','Contact_choice_value')">고유식별정보 수집</button>
          <button class="tablink" onclick="openPage('About', this,'#bdbdbd','About_choice_value')">개인정보활용 동의</button>
        </div>

        <div id="term_box">

        <div id="Home" class="tabcontent" >
          <h3>여행표준약관</h3>
          <p  ><b>제1조 (목적)</b></p>
          <p  >이 약관은 (주)하나투어(이하 ‘당사’라 한다.)와 여행자가 체결한 국외 여행계약의 세부 이행 및 준수 사항을 정함을 목적으로 합니다.</p>
          <br> <br><p  ><b>제2조 (당사와 여행자 의무)</b></p>
          <p  >1. 당사는 여행자에게 안전하고 만족스러운 여행서비스를 제공하기 위하여 여행알선 및 안내, 운송, 숙박 등 여행 계획의 수립 및 실행 과정에서 맡은 바 임무를 충실히 수행하여야 합니다.</p>
          <p  >2. 여행자는 안전하고 즐거운 여행을 위하여 여행자 간 화합도모 및 당사의 여행 질서 유지에 적극 협조하여야 합니다.</p>
          <br> <br><p  ><b>제3조 (용어의 정의)</b></p>
          <p  >여행의 종류 및 정의, 해외여행 수속대행업의 정의는 다음과 같습니다.</p>
          <p  >1) 기획여행 : 당사가 미리 여행 목적지 및 관광 일정, 여행자에게 제공될 운송 및 숙식 서비스 내용(이하 ‘여행서비스’라 함), 여행 요금을 정하여 광고 또는 기타 방법으로 여행자를 모집하여 실시하는 여행.</p>
          <p  >2) 희망여행 : 여행자(개인 또는 단체)가 희망하는 여행 조건에 따라 당사가 운송, 숙식, 관광 등 여행에 관한 전반적인 계획을 수립하여 실시하는 여행.</p>
          <p  >3) 해외여행 수속대행(이하 수속대행 계약이라 함) : 당사가 여행자로부터 소정의 수속대행 요금을 받기로 약정하고, 여행자의 위탁에 따라 다음에 열거하는 업무(이하 수속대행 업무라 함)를 대행하는 것.</p>
          <p  >가. 사증, 재입국 허가 및 각종 증명서 취득에 관한 수속</p>
          <p  >나. 출입국 수속 서류 작성 및 기타 관련 업무</p>
          <br> <br><p  ><b>제4조(계약의 구성)</b></p>
          <p  >1. 여행계약은 여행 계약서(붙임)와 여행약관, 여행 일정표(또는 여행 설명서)를 계약내용으로 합니다.</p>
          <p  >2. 여행 일정표(또는 여행 설명서)에는 여행일자 별 여행지와 관광 내용, 교통수단, 쇼핑 횟수, 숙박장소, 식사 등 여행 실시 일정 및 여행사 제공 서비스 내용과 여행자 유의사항이 포함되어야 합니다.</p>
          <br> <br><p  ><b>제5조 (특약)</b></p>
          <p  >당사와 여행자는 관계 법규에 위반되지 않는 범위 내에서 서면으로 특약을 맺을 수 있습니다. 이 경우 표준 약관과 다름을 당사는 여행자에게 설명하여야 합니다.</p>
          <br> <br><p  ><b>제6조 (안전정보 제공 및 계약서 등 교부)</b></p>
          <p  >당사는 여행자와 여행계약을 체결할 때 여행약관과 외교부 해외 안전여행 홈페이지(www.0404.go.kr)에 게재된 여행지 안전 정보를 제공하여야 하며, 여행계약을 체결한 경우 계약서와 여행 일정표 (또는 여행 설명서)를 각 1부씩 여행자에게 교부하여야 합니다.</p>
          <br> <br><p  ><b>제7조 (계약서 및 약관 등 교부 간주)</b></p>
          <p  >당사와 여행자는 다음 각 호의 경우 여행 계약서와 여행약관 및 여행 일정표(또는 여행 설명서)가 교부된 것으로 간주합니다.</p>
          <p  >1) 여행자가 인터넷 등 전자 정보망으로 제공된 여행 계약서, 약관 및 여행 일정표(또는 여행 설명서)의 내용에 동의하고 여행계약의 체결을 신청한 데 대해 당사가 전자 정보망 내지 기계적 장치 등을 이용하여 여행자에게 승낙의 의사를 통지한 경우</p>
          <p  >2) 당사가 팩시밀리 등 기계적 장치를 이용하여 제공한 여행 계약서, 약관 및 여행 일정표(또는 여행 설명서)의 내용에 대하여 여행자가 동의하고 여행계약의 체결을 신청하는 서면을 송부한 데 대해 당사가 전자 정보망 내지 기계적 장치 등을 이용하여 여행자에게 승낙의 의사를 통지한 경우</p>
          <br> <br><p  ><b>제8조 (당사의 책임)</b></p>
          <p  >당사는 여행 출발 시부터 도착 시까지 당사 본인 또는 그 고용인, 현지 여행업자 또는 그 고용인 등(이하 ‘사용인’이라 함)이 제2조 제1항에서 규정한 당사 임무와 관련하여 여행자에게 고의 또는 과실로 손해를 가한 경우 책임을 집니다.</p>
          <br> <br><p  ><b>제9조 (최저 행사 인원 미 충족 시 계약해제)</b></p>
          <p  >1. 당사가 최저 행사 인원 충족되지 아니하여 여행계약을 해제하는 경우 여행개시 7일 전까지 여행자에게 통지하여야 합니다.</p>
          <p  >2. 당사가 여행 참가자 수 미달로 전항의 기일 내 통지를 하지 아니하고 계약을 해제하는 경우 이미 지급받은 계약금 환급 외에 다음 각 항목의 1의 금액을 여행자에게 배상하여야 합니다.</p>
          <p  >1) 여행개시 1일전까지 통지 시 : 여행요금의 30%</p>
          <p  >2) 여행 당일 통지 시 : 여행요금의 50%</p>
          <p  > (※ 여행요금이란 일정표상 명시된 총 상품 가격을 의미한다)</p>
          <br> <br><p  ><b>제10조 (계약 체결 거절)</b></p>
          <p  >당사는 여행자에게 다음 각 호의 1에 해당하는 사유가 있을 경우에는 여행자와의 계약 체결을 거절할 수 있습니다.</p>
          <p  >1) 다른 여행자에게 폐를 끼치거나 여행의 원활한 실시에 지장이 있다고 인정될 때</p>
          <p  >2) 질병 기타 사유로 여행이 어렵다고 인정될 때</p>
          <p  >3) 명시한 최대 행사 인원이 초과되었을 때</p>
          <p  >4) 일정표에 최저 행사 인원이 미달되었을 때</p><br> <br>


        </div>

        <div id="News" class="tabcontent" >
          <h3>위치기반 서비스 동의</h3>
          <p ><b>제 1 조 (목적)</b></p>
          <p  >본 약관은 주식회사 하나투어(이하 “회사”)가 제공하는 위치기반서비스 약관에 부합하여 관련서비스 제공하는 회사와 개인위치정보주체와의 권리, 의무 및 책임사항, 기타 필요한 사항을 규정함을 목적으로 합니다.</p>
          <br><br>
          <p  ><b>제 2 조 (이용약관의 효력 및 변경)</b></p>
          <p  >① 본 약관은 서비스를 이용하는 고객 또는 개인위치정보주체가 본 약관에서 정의하는 회사의 서비스에 절차에 따라 동의함으로써 효력이 발생합니다.</p>
          <p  >② 이용자는 서비스의 동의 요청에 따라서 지정한 “동의” 선택 및 위치정보 조회에 대한 문자를 수신하였을 경우 이용자가 위치 정보와 관련된 내용을 충분히 이해하였으며, 그 적용에 동의한 것으로 봅니다.</p>
          <p  >③ 회사는 위치정보의 보호 및 이용 등에 관한 법률, 콘텐츠산업 진흥법, 전자상거래 등에서의 소비자보호에 관한 법률, 소비자기본법 약관의 규제에 관한 법률 등 관련법령을 위배하지 않는 범위에서 본 약관을 개정할 수 있습니다.</p>
          <p  >④ 회사가 약관을 개정할 경우에는 기존약관과 개정약관 및 개정약관의 적용일자와 개정사유를 명시하여 현행약관과 함께 그 적용일자 10일 전부터 적용일 이후 상당한 기간 동안 공지만을 하고, 개정 내용이 이용자에게 불리한 경우에는 그 적용일자 30일 전부터 적용일 이후 상당한 기간 동안 각각 이를 서비스 홈페이지에 게시하거나 이용자에게 음성 또는 전자적 형태(SMS 등)로 약관 개정 사실을 발송하여 고지합니다.</p>
          <p  >⑤ 회사가 전항에 따라 이용자에게 통지하면서 공지 또는 공지? 고지일로부터 개정약관 시행일 7일 후까지 거부의사를 표시하지 아니하면 이용약관에 승인한 것으로 봅니다.</p>
          <br><br>
          <p  ><b>제 3 조 (관계법령의 적용)</b></p>
          <p  >본 약관은 신의성실의 원칙에 따라 공정하게 적용하며, 본 약관에 명시되지 아니한 사항에 대하여는 관계법령 또는 상관례에 따릅니다.</p>
          <br><br>
          <p  ><b>제 4조 (서비스의 내용)</b></p>
          <p  >① 회사는 직접 위치정보를 수집하거나 위치정보사업자로부터 위치정보를 전달받아 아래와 같은 위치기반서비스를 제공합니다.</p>
          <p  >1. 산뜻 고객센터 : (지역번호없이) 02-000-0000 발신 고객 중 위치정보활용에 동의한 고객에 한하여 이용자와 가까운 위치에
          있는 산뜻 상담원과 전화 연결</p>
          <p  >2. 상품예약서비스 : PC IP 정보 및 모바일 GPS 위치정보를 활용하여 가까운 하나투어 (도우미 여행사) 예약 연결</p>
          <p  >3. 여행정보 서비스 제공 : 개인위치정보주체 또는 이동성이 있는 기기의 위치정보를 제공 시 위치정보를 이용한 여행정보, 이벤트 등
            다양한 편의 서비스를 제공합니다.</p>
          <p  >② 회사는 만 14세 이상의 회원에 대해서만 개인위치정보를 이용한 위치기반서비스를 제공합니다.</p>
          <br><br>
          <p  ><b>제 5 조 (서비스 이용요금)</b></p>
          <p  >회사가 제공하는 서비스는 기본적으로 무료입니다.</p>
            <br><br>

        </div>

        <div id="Contact" class="tabcontent" >
          <br>
          <h3>고유식별정보 수집</h3>
          <br><br><p class="information_collect" ><b>당사는 개인정보보호법을 준수하며 서비스 수행의 목적에 한하여 최소한의 고유식별정보를 수집,이용하며 기준은 아래와 같습니다.</b></p>
          <br><br><p class="information_collect"><b>1. 고유식별 정보 수집/이용 목적 : 해외여행 상품예약시 출국가능 여부파악 및 여행자 본인식별</b></p>
          <br><br><p class="information_collect"><b>2. 수집하는 고유식별 정보의 항목 : 여권번호 (여권만료일)</b></p>
          <br><br><p class="information_collect"><b>3. 고유식별정보의 보유 및 이용기간 : 여행상품 서비스 수행목적의 완료시점까지</b></p>
          <br><br><p class="information_collect"><b>*동의거부권</b></p>
          <br><br><p class="information_collect"><b>개인정보주체는 고유식별정보(여권번호 등) 에 대한 수집동의를 거부할 권리가 있습니다.</b></p>
          <p class="information_collect"><b>동의를 거부할 경우 출국자 확인이 불가하여 예약서비스 수행이 불가함을 알려드립니다.</b></p>
          <br><br>
        </div>

        <div id="About" class="tabcontent" >
          <h3>개인정보활용 동의</h3>
          <br><br><p class="information_collect"><b>1. 개인정보 활용 목적</b></p>
          <p class="information_collect"><b>고객님의 개인정보는 고객님에게 적합한 맞춤 여행상품 안내서비스 및 맞춤 상담을 위해 아래와 같이 활용될 수 있습니다.</b></p>
          <p class="information_collect" style="font-size:14px;"><b>(1) 회사의 여행 상품 및 여행관련 서비스를 이용한 고객에게 한정하여 회사가 기획한 여행상품이나 다양한 맞춤서비스 홍보 및 안내하기 위하여 개인정보 개인정보 활용에 동의한 고객에게 다양한 맞춤 서비스를 제공할 수 있습니다.</b></p>
          <p class="information_collect" style="font-size:14px;"><b>(2) 신규서비스 개발 및 특화, 인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 당사 및 제휴사 상품 / 제휴카드 안내, 이벤트 등 광고성 정보 전달, 회원의 서비스 이용에 대한 통계, 회원 대상 각종 마케팅 활동에 활용됩니다.</b></p>
          <br><br><p class="information_collect"><b>2. 개인정보의 이용 및 보유기간</b></p>
          <p class="information_collect"><b>개인정보 활용에 동의한 고객님에 한해 서비스 제공 및 관계 법령에 따른 보존기간까지</b></p>
          <br><br><p class="information_collect"><b>3. 동의를 거부할 권리 및 동의를 거부할 경우의 불이익</b></p>
          <p class="information_collect"><b>개인정보주체는 개인정보 활용에 대한 동의를 거부할 권리가 있습니다. 동의를 거부할 경우 여행 맞춤 서비스 및 정보제공이 일부 제한 될 수 있으며 회원가입 및 여행서비스 이용에는 영향이 없습니다.</b></p>
          <br><br><br><br>
        </div>
        <div id="choice_values">
        <p class="choice_value" id="Home_choice_value" ><b>(여행표준약관)</b><input type="radio" name="Home_choice_value" value="" id="h_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input id="h_n" type="radio" name="Home_choice_value" value="" checked>동의하지 않습니다.</p>
        <p class="choice_value" id="News_choice_value"  ><b>(위치기반 서비스 동의)</b><input type="radio" name="News_choice_value" value="" id="n_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input id="n_n" type="radio" name="News_choice_value" value="" checked>동의하지 않습니다.</p>
        <p class="choice_value" id="Contact_choice_value"  ><b>(고유식별정보 수집)</b><input type="radio" name="Contact_choice_value" value="" id="c_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input id="c_n" type="radio" name="Contact_choice_value" value="" checked>동의하지 않습니다.</p>
        <p class="choice_value" id="About_choice_value" ><b>(개인정보활용 동의)</b><input type="radio" name="About_choice_value" value="" id="a_y">동의합니다.&nbsp;&nbsp;&nbsp;&nbsp;<input id="a_n" type="radio" name="About_choice_value" value="" checked>동의하지 않습니다.</p>
        </div>
        </div>
        <script>
        function openPage(pageName,elmnt,color,choiceName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          choice_value = document.getElementsByClassName("choice_value");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            choice_value[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablink");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "";
          }
          document.getElementById(pageName).style.display = "block";
          document.getElementById(choiceName).style.display = "block";
          elmnt.style.backgroundColor = color;
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        </script>
        </div>


      </div>
      <!-- end of middle2 -->
      </div>


      <div id="reserve_detail_menu">
        <div id="cost_info">
          <p>상품요금정보</p>
        </div>
        <div id="reserve_pay_view">
          <p id="reserve_total_pay">최종결제금액</p>
          <b id="reserve_money">999,000</b> <p id="won">원</p>
          <p class="subtext2">유류할증료,제세공과금 포함</p>
          <p class="subtext2">※발권일/환율에 따라 변경 가능합니다</p>
          <p class="line">-----------------------------------------------------------</p>
        </div>
        <div id="increase_box" >

        </div>
        <div id="reserve_button">
          <!-- <a href="#"><div id="reserve_finish"> <b>예약마감</b></div></a><br> -->
          <input type="button" id="reserve_finish" value="예약마감">
        </div>
        <div id="right_footer"></div>
      </div>


  <!-- end of wrap -->
  </div>
  </body>


<br><br><br>
<footer>
  <?php include $_SERVER['DOCUMENT_ROOT']."/santteut/common/lib/footer.php";?>
</footer>
</html>