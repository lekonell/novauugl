<?php
  include "config.php";

  function get_random_string($type = '', $len = 10) {
      $lowercase = 'abcdefghijklmnopqrstuvwxyz';
      $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $numeric = '0123456789';
      $special = '`~!@#$%^&*()-_=+\\|[{]};:\'",<.>/?';
      $key = '';
      $token = '';
      if ($type == '') {
          $key = $lowercase.$uppercase.$numeric;
      } else {
          if (strpos($type,'09') > -1) $key .= $numeric;
          if (strpos($type,'az') > -1) $key .= $lowercase;
          if (strpos($type,'AZ') > -1) $key .= $uppercase;
          if (strpos($type,'$') > -1) $key .= $special;
      }
      for ($i = 0; $i < $len; $i++) {
          $token .= $key[mt_rand(0, strlen($key) - 1)];
      }
      return $token;
  }

  $timeymdhis = date("Y-m-d H:i:s", time());

  if ($_POST["act"] == "Share") {
    $q = mysqli_query($con, "SELECT * FROM novacode WHERE `IP` = '$_SERVER[REMOTE_ADDR]' ORDER BY `no` DESC");
    $d = mysqli_fetch_array($q);

    if ($d) {
      $qx = mysqli_query($con, "SELECT * FROM novalog WHERE `act` = 'create_code' AND `act_detail` = '$d[CODE]' AND `IP` = '$_SERVER[REMOTE_ADDR]'");
      $dx = mysqli_fetch_array($qx);

      $dt = strtotime($dx["date"]);
      if (time() - $dt < 10) {
        mysqli_query($con, "INSERT INTO novalog SET `date` = '$timeymdhis', `act` = 'create_code_fail', `act_detail` = 'delay', `IP` = '$_SERVER[REMOTE_ADDR]'");
        echo '{"rtncode":"2", "msg":"10초 내로 다시 코드를 생성할 수 없습니다."}';
        exit;
      }
    }

    while (1) {
      $code = get_random_string('azAZ09', '6');
      $q = mysqli_query($con, "SELECT * FROM novacode WHERE `CODE` = '$code'");
      $d = mysqli_fetch_array($q);

      if (!$d) { break; }
    }
    mysqli_query($con, "INSERT INTO novacode SET `CODE` = '$code', `Part` = '$_POST[Part]', `Enhance` = '$_POST[Enhance]', `Subcore` = '$_POST[Subcore]', `IP` = '$_SERVER[REMOTE_ADDR]'");
    mysqli_query($con, "INSERT INTO novalog SET `date` = '$timeymdhis', `act` = 'create_code', `act_detail` = '$code', `IP` = '$_SERVER[REMOTE_ADDR]'");
    echo '{"rtncode":"1", "link":"http://nova1492.uu.gl/'.$code.'"}';
    exit;
  }

  $getcode = "false";
  $x = $_GET["code"];
  $x = str_replace("'", "", $x);
  $x = str_replace('"', "", $x);
  $x = str_replace("(", "", $x);
  $x = str_replace(")", "", $x);
  if ($x && strlen($x) == 6) {
    mysqli_query($con, "INSERT INTO novalog SET `date` = '$timeymdhis', `act` = 'visit_code', `act_detail` = '$x', `IP` = '$_SERVER[REMOTE_ADDR]'");
    $q = mysqli_query($con, "SELECT * FROM novacode WHERE `CODE` = '$x'");
    $d = mysqli_fetch_array($q);

    if ($d["CODE"] != $null) {
      $getcode = "success";
      $Part = explode("/", $d["Part"]);
      $Enhance = explode("|", $d["Enhance"]);
      $MPE = explode("/", $Enhance[0]);
      $BPE = explode("/", $Enhance[1]);
      $APE = explode("/", $Enhance[2]);
      $Subcore = explode("/", $d["Subcore"]);
    }
    else {
      $getcode = "fail";
    }
  }
  else {
    mysqli_query($con, "INSERT INTO novalog SET `date` = '$timeymdhis', `act` = 'visit', `IP` = '$_SERVER[REMOTE_ADDR]'");
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nova1492 Simulator</title>
    <style type="text/css">
      * {
        font-size: 9pt;
        color: white;
        cursor: url('/novaimg/cursor.png'), auto;
      }
      li {
        list-style: none;
      }
      div.main {
        position: relative;
        width: 859px;
        margin: 0 auto;
        overflow: hidden;
        margin-top: 120px;
      }
      div.UseInfo {
        position: absolute;
        width: 400px;
        height: 300px;
        left: 204px;
        top: 110px;
        opacity: 0.9;
        z-index: 9999;
        background-color: white;
      }
      div.UseInfo p {
        color: black;
        text-align: center;
      }
      div.UpdateLog {
        position: absolute;
        width: 400px;
        height: 440px;
        left: 204px;
        top: 110px;
        opacity: 0.9;
        z-index: 9999;
        background-color: white;
      }
      div.UpdateLog p {
        color: black;
        margin-left: 10px;
      }
      div.UpdateLog b {
        color: black;
      }
      div.UnitPart {
        position: relative;
        width: 391px;
        height: 564px;
        float: left;
        overflow: hidden;
      }
      div.UnitPart li {
        float: left;
        height: 136px;
        overflow: hidden;
        background-repeat: no-repeat;
      }
      div.UnitPart li.default {
        width: 340px;
        background-image: url('/novaimg/lab.png');
      }
      div.UnitPart li.highlight {
        width: 340px;
        background-image: url('/novaimg/lab-highlight.png');
      }
      div.UnitPart li.unfit {
        width: 340px;
        background-image: url('/novaimg/lab-unfit.png');
      }
      div.UnitPart li.extend {
        margin-left: -23px;
        width: 74px;
        background-image: url('/novaimg/lab-extend.png');
      }
      div.unfit {
        position: absolute;
        top: 546px;
        width: 340px;
        text-align: center;
        font-weight: bold;
        color: yellow;
      }
      div.UnitPart div.Unit {
        position: absolute;
        width: 100px;
        height: 70px;
      }
      div.UnitPart div {
        clear: both;
      }
      div.UnitPart div#MP {
        top: 30px;
        left: 40px;
      }
      div.UnitPart div#BP {
        top: 166px;
        left: 40px;
      }
      div.UnitPart div#AP {
        top: 302px;
        left: 40px;
      }
      div.UnitPart div#AcP {
        top: 438px;
        left: 40px;
      }
      div.UnitPart div.SubCore {
        z-index: 100;
      }
      div.Unit {
        background-size: 100px 70px;
      }
      div.Unit div.SubArea {
        position: absolute;
        width: 100px;
        height: 70px;
      }
      div.Unit ul.SubCore {
        width: 60px;
        height: 100px;
        padding-left: 20px;
        margin: 0;
        z-index: 100;
      }
      div.Unit div.BlockSubCore {
        position: absolute;
        width: 32px;
        height: 32px;
        top: -10px;
        left: 6px;
        background-size: 32px 32px;
      }
      div.Unit div.BlockArmType {
        position: absolute;
        width: 32px;
        height: 32px;
        top: -10px;
        left: 58px;
        background-size: 32px 32px;
      }
      div.BlockArmType.ArmA {
        background-image: url('/novaimg/팔형.png');
      }
      div.BlockArmType.ArmS {
        background-image: url('/novaimg/어깨형.png');
      }
      div.BlockArmType.ArmT {
        background-image: url('/novaimg/탑형.png');
      }
      div.Unit ul.SubCore li.SubCore {
        float: left;
        width: 20px;
        height: 20px;
        background-size: 20px 20px;
        // cursor: pointer;
      }
      div.Unit ul.SubCore li.Cancel {
        float: left;
        margin-left: 10px;
        width: 40px;
        height: 20px;
        text-align: center;
        // cursor: pointer;
        font-size: 8pt;
      }
      .CodeAr {
        background-image: url('/novaimg/subcore/에어리움.png');
      }
      .CodeTa {
        background-image: url('/novaimg/subcore/타우리움.png');
      }
      .CodeGe {
        background-image: url('/novaimg/subcore/제미늄.png');
      }
      .CodeCn {
        background-image: url('/novaimg/subcore/켄서늄.png');
      }
      .CodeLe {
        background-image: url('/novaimg/subcore/레오늄.png');
      }
      .CodeVi {
        background-image: url('/novaimg/subcore/비르늄.png');
      }
      .CodeLi {
        background-image: url('/novaimg/subcore/리브리움.png');
      }
      .CodeSc {
        background-image: url('/novaimg/subcore/스콜피움.png');
      }
      .CodeSg {
        background-image: url('/novaimg/subcore/사지타리움.png');
      }
      .CodeCa {
        background-image: url('/novaimg/subcore/카프리움.png');
      }
      .CodeAq {
        background-image: url('/novaimg/subcore/아쿠아리움.png');
      }
      .CodePs {
        background-image: url('/novaimg/subcore/피스케늄.png');
      }
      div.Unit div.UnitDetail {
        position: absolute;
        top: -20px;
        left: 120px;
        width: 160px;
        height: 110px;
      }
      div.UnitDetail div.ExtendInfo {
        position: absolute;
        top: 24px;
        left: 152px;
        width: 77px;
        height: 110px;
      }
      div.ExtendInfo div {
        float: left;
        height: 16px;
      }
      div.UnitDetail div {
        clear: none;
      }
      div.UnitDetail div.R {
        margin-left: 0px;
      }
      div.UnitDetail div.typeA {
        width: 77px;
        height: 16px;
        float: left;
      }
      div.UnitDetail div.Level {
        background-image: url('/novaimg/status-level.png');
      }
      div.UnitDetail div.WA {
        background-image: url('/novaimg/status-weight.png');
      }
      div.UnitDetail div.WB {
        background-image: url('/novaimg/status-weight-2.png');
      }
      div.UnitDetail div.Speed {
        background-image: url('/novaimg/status-speed.png');
      }
      div.UnitDetail div.Armor {
        background-image: url('/novaimg/status-armor.png');
      }
      div.UnitDetail div.Sight {
        background-image: url('/novaimg/status-sight.png');
      }
      div.UnitDetail div.Range {
        background-image: url('/novaimg/status-range.png');
      }
      div.UnitDetail div.Delay {
        background-image: url('/novaimg/status-delay.png');
      }
      div.UnitDetail div.Watt {
        background-image: url('/novaimg/status-watt.png');
      }
      div.UnitDetail div.AttackType {
        background-image: url('/novaimg/status-attacktype.png');
      }
      div.UnitDetail div.typeB {
        width: 154px;
        height: 16px;
        float: left;
      }
      div.UnitDetail div.Watt.Extend {
        background-image: url('/novaimg/status-watt-extend.png');
      }
      div.UnitDetail div.HP.Extend {
        background-image: url('/novaimg/status-hp-extend.png');
      }
      div.UnitDetail div.Damage.Extend {
        background-image: url('/novaimg/status-damage-extend.png');
      }
      div.UnitDetail div.Damage {
        background-image: url('/novaimg/status-damage.png');
      }
      div.UnitDetail div.HP {
        background-image: url('/novaimg/status-hp.png');
      }
      div.UnitDetail div.SubCore span.SubCore {
        width: 159px;
        margin-left: 5px;
        text-align: left;
        color: lightgreen;
      }
      div.UnitDetail div.typeC {
        float: left;
        width: 77px;
        height: 100px;
      }
      div.UnitDetail div.typeD {
        float: left;
        width: 77px;
        margin-left: 5px;
      }
      div.UnitDetail span.Space {
        float: left;
        display: block;
        width: 28px;
        height: 17px;
        margin-left: -4px;
        margin-bottom: 4px;
      }
      div.UnitDetail span.Special {
        float: left;
        width: 28px;
        height: 17px;
        margin-left: -4px;
        margin-top: 3px;
        margin-bottom: 4px;
        background-image: url('/novaimg/part-special.png');
        background-repeat: no-repeat;
        // cursor: pointer;
      }
      div.UnitDetail span.Normal {
        float: left;
        width: 28px;
        height: 17px;
        margin-left: -4px;
        margin-top: 3px;
        margin-bottom: 4px;
        background-image: url('/novaimg/part-normal.png');
        background-repeat: no-repeat;
        // cursor: pointer;
      }
      div.UnitDetail span.Nametag {
        float: left;
        width: 132px;
        height: 20px;
        margin-left: 2px;
        margin-bottom: 4px;
        text-align: left;
      }
      div.UnitDetail span.Name {
        height: 20px;
        padding-bottom: 2px;
        font-size: 10pt;
        color: #DDF057;
        font-weight: bold;
        letter-spacing: -1px;
      }
      div.UnitDetail span.Star {
        margin-top: -8px;
        height: 20px;
        padding-bottom: 2px;
        font-size: 10pt;
        color: #DDF057;
        font-weight: bold;
        letter-spacing: -2px;
      }
      div.UnitDetail div span {
        float: left;
        width: 73px; 
        text-align: right;
        font-size: 9pt;
        padding-right: 4px;
      }
      div.UnitDetail span.Enhance {
        float: left;
        height: 16px;
        text-align: left;
        z-index: 100;
      }
      div.UnitDetail span.Enhance span {
        width: auto;
        padding-right: 0px;
        font-size: 8pt;
      }
      div.UnitDetail span.Enhance span.oper {
        width: 8px;
        height: 16px;
        color: lightgreen;
        text-align: center;
      }
      div.UnitDetail span.Enhance span.nv {
        width: 20px;
        height: 16px;
        color: lightgreen;
        text-align: right;
        margin-left: -2px;
      }
      div.UnitDetail span.Enhance span.slash {
        width: 6px;
        height: 16px;
        color: yellow;
        text-align: center;
        margin-left: 1px;
      }
      div.UnitDetail span.Enhance span.mv {
        width: 20px;
        height: 16px;
        color: yellow;
        text-align: right;
        margin-left: -2px;
      }
      div.UnitDetail span.Enhance span.vp {
        width: 20px;
        height: 16px;
        color: white;
        text-align: center;
        margin-left: 2px;
      }
      div.UnitDetail div.Extend span.Watt {
        // cursor: pointer;
      }
      div.UnitDetail div.Extend span.HP {
        // cursor: pointer;
      }
      div.UnitDetail div.Extend span.Damage {
        // cursor: pointer;
      }
      div.UnitDetail span.EnhanceInput {
        text-align: left;
      }
      input.EnhanceInput {
        width: 24px;
        height: 16px;
        border: 1px solid #ccc;
        color: black;
      }
      div.UnitList {
        position: relative;
        width: 428px;
        height: 320px;
        float: left;
        margin-left: 20px;
        padding-left: 20px;
        white-space: nowrap;
      }
      div.UnitList ul {
        width: 214px;
        height: 156px;
        margin: 0;
        padding: 0;
        float: left;
        overflow: hidden;
        line-height: 23px;
        padding-top: 8px;
      }
      div.UnitList ul.MP {
        background-image: url('/novaimg/MP.png');
      }
      div.UnitList ul.BP {
        background-image: url('/novaimg/BP.png');
      }
      div.UnitList ul.AP {
        background-image: url('/novaimg/AP.png');
      }
      div.UnitList ul.AcP {
        background-image: url('/novaimg/AcP.png');
      }
      div.UnitList li {
        width: 136px;
        margin-left: 12px;
        padding-left: 6px;
        padding-right: 4px;
        clear: both;
        overflow: hidden;
      }
      .hidden {
        display: none;
      }
      div.UnitList li span.sl {
        letter-spacing: 1px;
      }
      div.UnitList li span.sr {
        padding-right: 3px;
      }
      div.UnitList li.highlight {
        background-image: url('/novaimg/list-highlight.png');
      }
      div.UnitInfo {
        position: relative;
        float: left;
        width: 130px;
        margin-top: 20px;
        margin-left: 20px;
        padding-left: 20px;
      }
      div.UnitInfo li {
        width: 120px;
        height: 16px;
        margin-top: 2px;
      }
      div.UnitInfo li span {
        float: right;
        width: 120px;
        margin-right: 4px;
        text-align: right;
      }
      div.UnitInfo li#UnitWatt {
        background-image: url('/novaimg/info-watt.png');
      }
      div.UnitInfo li#UnitHP {
        background-image: url('/novaimg/info-hp.png');
      }
      div.UnitInfo li#UnitSpeed {
        background-image: url('/novaimg/info-speed.png');
      }
      div.UnitInfo li#UnitDelay {
        background-image: url('/novaimg/info-delay.png');
      }
      div.UnitInfo li#UnitRange {
        background-image: url('/novaimg/info-range.png');
      }
      div.UnitInfo li#UnitSight {
        background-image: url('/novaimg/info-sight.png');
      }
      div.UnitInfo li#UnitDamage {
        background-image: url('/novaimg/info-damage.png');
      }
      div.UnitInfo li#UnitArmor {
        background-image: url('/novaimg/info-armor.png');
      }
      span.SpecialInfo {
        font-size: 8pt;
        letter-spacing: -1px;
      }
      div.info {
        width: 100%;
        float: left;
        border-top: 1px solid #404040;
        margin-top: 110px;
        padding-top: 10px;
        white-space: nowrap;
      }
      div.Share {
        position: relative;
        float: left;
        width: 428px;
        margin-top: 20px;
        margin-left: 40px;
      }
      div.ShareResult {
        position: relative;
        float: left;
        width: 428px;
        margin-top: 4px;
        margin-left: 40px;
      }
      div.Share span.Share {
        border: 1px solid rgba(255, 255, 255, 0.3);
        background-color: rgba(0, 0, 0, 0.3);
        font-weight: bold;
        padding-left: 3px;
        padding-right: 2px;
        padding-bottom: 2px;
        color: rgba(255, 255, 255, 0.5);
      }
      div.Share span.Share:hover {
        color: #00b3fd;
        border: 1px solid #00b3fd;
      }
      div.Share input.ShareLink {
        border: none;
        width: 172px;
        background-color: rgba(255, 255, 255, 0.3);
        color: white;
      }
      div.Share input.ShareLink:hover {
        color: lightgreen;
      }
      div.scrollup {
        width: 20px;
        height: 17px;
        background-image: url('/novaimg/scroll_up.png');
      }
      div.scrollup:hover {
        background-image: url('/novaimg/scroll_up-highlight.png');
      }
      div.scrolldown {
        width: 20px;
        height: 17px;
        background-image: url('/novaimg/scroll_down.png');
      }
      div.scrolldown:hover {
        background-image: url('/novaimg/scroll_down-highlight.png');
      }
      p {
        margin: 0;
      }
      a:link {
        text-decoration: none;
        color: #9A9A9A;
      }
    </style>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
    <script type="text/javascript">
      var start = ['0', '0', '0', '0'];
      var max = ['38', '52', '60', '69'];
      var item = new Array(220);
      item[0] = ['', '', '', '', '', '', '', '', '', '', '', '', '', ''];
      <?php
      for ($x=1;$x<=220;$x++) {
        $q = mysqli_query($con, "SELECT * FROM novaitem WHERE `no` = '$x'");
        while ($d = mysqli_fetch_array($q)) {
          $d["optspecial"] = str_replace("&lt;", "<", $d["optspecial"]);
          $d["optspecial"] = str_replace("&gt;", ">", $d["optspecial"]);
          echo 'item['.$x.'] = ['.$d["optlevel"].', '.$d["optweight"].', '.$d["optwatt"].', '.$d["optdamage"].', '.$d["opthp"].', '.$d["optarmor"].', '.$d["optspeed"].', '.$d["optdelay"].', "'.$d["optrange"].'", '.$d["optsight"].', "'.$d["optattacktype"].'", "'.$d["optarmtype"].'", "'.$d["optspecial"].'", "'.$d["name"].'"];'.chr(10);
          // echo 'item['.$x.'] = ['.$d["optlevel"].', '.$d["optweight"].', '.$d["optwatt"].', '.$d["optdamage"].', '.$d["opthp"].', '.$d["optarmor"].', '.$d["optspeed"].', '.$d["optdelay"].', "'.$d["optrange"].'", '.$d["optsight"].', "'.$d["optattacktype"].'", "'.$d["optarmtype"].'"];'.chr(10);
          // echo 'item['.($x-1).'] = ['.$d["optlevel"].', '.$d["optweight"].', '.$d["optwatt"].', '.$d["optdamage"].', '.$d["opthp"].', '.$d["optarmor"].', '.$d["optspeed"].', '.$d["optdelay"].', '.$d["optrange"].', '.$d["optsight"].', "'.$d["optattacktype"].'", "'.$d["optarmtype"].'", "'.$d["optspecial"].'"];'.chr(10);
        }
      }
      ?>
      var sctarget = null;
      var scti = -1;

      $(document).ready(function(){
        $("span#Info").mouseover(function(){
          $("div.UseInfo").removeClass("hidden");
        });
        $("span#Info").mouseout(function(){
          $("div.UseInfo").addClass("hidden");
        });

        $("span#UpdateLog").mouseover(function(){
          $("div.UpdateLog").removeClass("hidden");
        });
        $("span#UpdateLog").mouseout(function(){
          $("div.UpdateLog").addClass("hidden");
        });

        $("div.UnitPart li.PartView").mouseover(function(){
          if ($(this).hasClass("unfit")) { return false; }
          $(this).removeClass("default");
          $(this).addClass("highlight");
        });
        $("div.UnitPart li.PartView").mouseout(function(){
          if ($(this).hasClass("unfit")) { return false; }
          $(this).removeClass("highlight");
          $(this).addClass("default");
        });

        $("div.UnitList ul li").click(function(){
          var t = $(this).attr("type");
          $("div.UnitList ul li." + t).each(function(){
            $(this).removeClass("highlight");
          });
          $(this).addClass("highlight");
          
          var tn = $(this).children("span.sl").text();
          if (tn == "[미선택]") {
            $("div.UnitPart div#" + t).attr("style", "");
            $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Space").children("span.Special").addClass("hidden");
            $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Nametag").children("span.Name").addClass("hidden");
            $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Nametag").children("span.Star").addClass("hidden");
            if (t != "AcP") {
              $("div.UnitPart div#" + t).children("div.UnitDetail").children().each(function(){
                $(this).addClass("hidden");
              });
            }
            else {
              $("div.UnitPart div#" + t).children("div.UnitDetail").children("div.typeC").children().each(function(){
                $(this).addClass("hidden");
              });
              $("div.UnitPart div#" + t).children("div.UnitDetail").children("div.typeD").children().each(function(){
                $(this).addClass("hidden");
              });
            }

            refreshinfo();
            return false;
          }
          
          $("div.UnitPart div#" + t).attr("style", "background-image: url('/novaimg/res/" + tn + ".jpg')");
          $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Nametag").children("span.Name").removeClass("hidden");
          $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Nametag").children("span.Star").removeClass("hidden");

          if (t == "MP" || t == "BP" || t == "AP") {
            $("div.UnitPart div#" + t).children("div.UnitDetail").children().each(function(){
              $(this).removeClass("hidden");
            });
          }
          else if (t == "AcP") {
            $("div.UnitPart div#" + t).children("div.UnitDetail").children("div").children().each(function(){
              $(this).removeClass("hidden");
            });
          }
          $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Nametag").children("span.Name").text(tn);
          
          var o = $(this).attr("order");

          $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.Normal").addClass("hidden");
          $("div.UnitPart div#" + t).children("div.UnitDetail").children("span.SpecialInfo").addClass("hidden");

          if (t == "BP") { o = o * 1 + 38; }
          else if (t == "AP") { o = o * 1 + 38 + 52; }
          else if (t == "AcP") { o = o * 1 + 38 + 52 + 60; }

          selectpart(t, o);
          refreshinfo();
        });
        
        $("div.UnitList ul").mouseout(function(){
          sctarget = null;
          scti = -1;
        });
        $("div.UnitList ul").mouseover(function(){
          sctarget = $(this).attr("class");
          scti = $(this).attr("order");
        });

        $(document).on("keydown", function(event){
          if (event.which == 38) {
            start[scti] = start[scti] - 1;
            if (start[scti] < 0) { start[scti] = 0; }
            loadlist(sctarget, start[scti]);
          }
          else if (event.which == 40) {
            start[scti] = start[scti] * 1 + 1;
            if (start[scti] > max[scti] - 5) { start[scti] = max[scti] - 5; }
            loadlist(sctarget, start[scti]);
          }
        });

        $("div.scrollup").click(function(){
          var scti = $(this).attr("order");
          start[scti] = start[scti] - 6;
          if (start[scti] < 0) { start[scti] = 0; }
          loadlist($(this).attr("target"), start[scti]);
        });

        $("div.scrolldown").click(function(){
          var scti = $(this).attr("order");
          start[scti] = start[scti] * 1 + 6;
          if (start[scti] > max[scti] - 5) { start[scti] = max[scti] - 5; }
          loadlist($(this).attr("target"), start[scti]);
        });

        function loadlist(sn, st) {
          $("div.UnitList ul li." + sn).addClass("hidden");
          for (var s=st; s<st+6; s++) {
            $("div.UnitList ul li#" + sn + s).removeClass("hidden");
          }
        }

        $("div.Watt.Extend span.Watt").click(function(){
          if ($(this).parent().children("span.EnhanceInput").hasClass("hidden")) {
            $(this).parent().children("span.Enhance").addClass("hidden");
            $(this).parent().children("span.EnhanceInput").removeClass("hidden");
          }
          else {
            $(this).parent().children("span.Enhance").removeClass("hidden");
            $(this).parent().children("span.EnhanceInput").addClass("hidden");
          }
        });
        $("div.HP.Extend span.HP").click(function(){
          if ($(this).parent().children("span.EnhanceInput").hasClass("hidden")) {
            $(this).parent().children("span.Enhance").addClass("hidden");
            $(this).parent().children("span.EnhanceInput").removeClass("hidden");
          }
          else {
            $(this).parent().children("span.Enhance").removeClass("hidden");
            $(this).parent().children("span.EnhanceInput").addClass("hidden");
          }
        });
        $("div.Damage.Extend span.Damage").click(function(){
          if ($(this).parent().children("span.EnhanceInput").hasClass("hidden")) {
            $(this).parent().children("span.Enhance").addClass("hidden");
            $(this).parent().children("span.EnhanceInput").removeClass("hidden");
          }
          else {
            $(this).parent().children("span.Enhance").removeClass("hidden");
            $(this).parent().children("span.EnhanceInput").addClass("hidden");
          }
        });
        
        $("div.Extend span").click(function(){
          if ($(this).parent().children("span.Enhance").children("span.vp").text() == "(0%)") {
            $(this).parent().children("span.Enhance").addClass("hidden");
          }
        });
        
        $("input.EnhanceInput").click(function(){
          $(this).val("");
        });
        $("input.EnhanceInput").keydown(function(event){
          if (event.keyCode == 13) {
            if (!isNumeric($(this).val()) || $(this).val() < 0 || $(this).val() > 100) {
              window.alert('0 ≤ N ≤ 100 인 정수를 입력하세요.');
              $(this).val("");
              return false;
            }

            enhanceinput($(this).attr("part"), $(this).attr("target"), $(this).val());
            refreshinfo();
          }
        });

        function enhanceinput(Part, Target, Point) {
          $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.EnhanceInput").addClass("hidden");
          $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance").removeClass("hidden");
          
          $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance span.vp").text("(" + Point + "%)");
          $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance span.vp").attr("value", Point);
          
          var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance span.mv").text();
          if (Point == "0") {
            $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance").children("span.vp").text("(0%)");
            $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance").addClass("hidden");
            $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.EnhanceInput input.EnhanceInput").val("");
          }

          $("div.UnitPart div#" + Part + " div.UnitDetail div." + Target + " span.Enhance span.nv").text(enhancepoint(Part, Target, vp, Point));

          var v1 = $("div.UnitPart div#" + Part + " div.UnitDetail div.Watt span.Enhance span.vp").attr("value");
          var v2 = $("div.UnitPart div#" + Part + " div.UnitDetail div.HP span.Enhance span.vp").attr("value");
          var v3 = $("div.UnitPart div#" + Part + " div.UnitDetail div.Damage span.Enhance span.vp").attr("value");
          
          var star = v1 * 1 + v2 * 1 + v3 * 1;
          if (star < 30) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("");
          }
          else if (star >= 31 && star <= 50) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("☆");
          }
          else if (star >= 51 && star <= 80) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★");
          }
          else if (star >= 81 && star <= 100) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★☆");
          }
          else if (star >= 101 && star <= 130) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★");
          }
          else if (star >= 131 && star <= 160) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★☆");
          }
          else if (star >= 161 && star <= 200) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★★");
          }
          else if (star >= 201 && star <= 240) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★★☆");
          }
          else if (star >= 241 && star <= 260) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★★★");
          }
          else if (star >= 261 && star <= 280) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★★★☆");
          }
          else if (star >= 281 && star <= 300) {
            $("div.UnitPart div#" + Part + " div.UnitDetail span.Nametag span.Star").text("★★★★★");
          }
        }

        function isNumeric(n) {
          return !isNaN(parseFloat(n)) && isFinite(n);
        }

        function enhancepoint(part, type, max, percent) {
          var p = "0." + percent;
          if (p == "0.100") { p = 1; }

          if (part == "MP") {
            if (type == "Watt") {
              return Math.round(max * p);
            }
            else {
              return Math.floor(max * p);
            }
          }
          else if (part == "BP") {
            if (type == "HP") {
              return Math.ceil(max * p);
            }
            else {
              return Math.floor(max * p);
            }
          }
          else if (part == "AP") {
            if (type == "HP") {
              return Math.round(max * p);
            }
            else {
              return Math.floor(max * p);
            }
          }
        }

        function selectpart(Part, o) {
          if (item[o][13] == "") {
            $("div.UnitPart div#" + Part).attr("style", "");
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").addClass("hidden");
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Nametag").children("span.Name").addClass("hidden");
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Nametag").children("span.Star").addClass("hidden");
            if (Part != "AcP") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children().each(function(){
                $(this).addClass("hidden");
              });
            }
            else {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeC").children().each(function(){
                $(this).addClass("hidden");
              });
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children().each(function(){
                $(this).addClass("hidden");
              });
            }

            refreshinfo();
            return false;
          }
          
          $("div.UnitPart div#" + Part).attr("style", "background-image: url('/novaimg/res/" + item[o][13] + ".jpg')");
          $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Nametag").children("span.Name").removeClass("hidden");
          $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Nametag").children("span.Star").removeClass("hidden");

          if (Part == "MP" || Part == "BP" || Part == "AP") {
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children().each(function(){
              $(this).removeClass("hidden");
            });
          }
          else if (Part == "AcP") {
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div").children().each(function(){
              $(this).removeClass("hidden");
            });
          }
          $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Nametag").children("span.Name").text(item[o][13]);

          $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Normal").addClass("hidden");
          $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.SpecialInfo").addClass("hidden");

          if (Part == "MP") {
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Level").children("span.Level").text(item[o][0]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Weight").children("span.Weight").text(item[o][1]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Speed").children("span.Speed").text(item[o][6]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Armor").children("span.Armor").text(item[o][5]);
            if (item[o][5] == 0) {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Armor").addClass("hidden");
            }
            if (item[o][5] < 0) {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Armor").children("span.Armor").attr("style", "color: yellow");
            }
            else {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Armor").children("span.Armor").attr("style", "");
            }
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Watt").text(item[o][2]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.HP").text(item[o][4]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Damage").text(item[o][3]);
            
            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.Watt span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            var p = Math.floor(item[o][2] / 4);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "Watt", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Enhance").children("span.mv").text(p);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.HP span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            p = Math.floor((item[o][2] - 70) / 4);
            if (p < 0) { p = 0; }
            p = p + 50;
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "HP", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.Enhance").children("span.mv").text(p);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.Damage span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            p = Math.ceil((item[o][2] - 110) / 30);
            if (p < 0) { p = 0; }
            p = p + 3;
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "Damage", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Enhance").children("span.mv").text(p);

            if (item[o][12] != "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").removeClass("hidden");
            }
            else if (item[o][12] == "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").addClass("hidden");
            }

            $("div.UnitPart div#" + Part).attr("target", o);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.SpecialInfo").html(item[o][12]);

            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Delay span").text(plusminus(item[o][7]));
            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Range span").text(plusminus(item[o][8]));
            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Sight span").text(plusminus(item[o][9]));

            if (item[o][7] == "0" && item[o][8] == "0" && item[o][9] == "0") {
              $("div.UnitPart li#" + Part + "Extend").addClass("hidden");
            }
            else {
              $("div.UnitPart li#" + Part + "Extend").removeClass("hidden");
            }

            if (item[o][7] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Delay").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Delay").addClass("hidden"); }
            if (item[o][8] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Range").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Range").addClass("hidden"); }
            if (item[o][9] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Sight").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Sight").addClass("hidden"); }
          }
          else if (Part == "BP") {
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Level").children("span.Level").text(item[o][0]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Weight").children("span.Weight").text(item[o][1]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Sight").children("span.Sight").text(item[o][9]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Armor").children("span.Armor").text(item[o][5]);

            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Watt").text(item[o][2]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.HP").text(item[o][4]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Damage").text(item[o][3]);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.Watt span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            var p = Math.floor(item[o][2] / 4);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "Watt", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Enhance").children("span.mv").text(p);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.HP span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            p = Math.floor(item[o][4] / 4);
            p = p + 50;
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "HP", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.Enhance").children("span.mv").text(p);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.Damage span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            p = Math.ceil((item[o][2] - 110) / 30);
            if (p < 0) { p = 0; }
            p = p + 3;
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "Damage", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Enhance").children("span.mv").text(p);

            if (item[o][12] != "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").removeClass("hidden");
            }
            else if (item[o][12] == "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").addClass("hidden");
            }

            $("div.UnitPart div#" + Part).attr("target", o);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.SpecialInfo").html(item[o][12]);

            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Delay span").text(plusminus(item[o][7]));
            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Speed span").text(plusminus(item[o][6]));
            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Range span").text(plusminus(item[o][8]));

            if (item[o][7] == "0" && item[o][6] == "0" && item[o][8] == "0") {
              $("div.UnitPart li#" + Part + "Extend").addClass("hidden");
            }
            else {
              $("div.UnitPart li#" + Part + "Extend").removeClass("hidden");
            }

            if (item[o][7] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Delay").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Delay").addClass("hidden"); }
            if (item[o][6] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Speed").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Speed").addClass("hidden"); }
            if (item[o][8] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Range").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Range").addClass("hidden"); }
          }
          else if (Part == "AP") {
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Level").children("span.Level").text(item[o][0]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Weight").children("span.Weight").text(item[o][1]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Range").children("span.Range").text(item[o][8]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Delay").children("span.Delay").text(item[o][7]);

            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Watt").text(item[o][2]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.HP").text(item[o][4]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Damage").text(item[o][3]);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.Watt span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            var p = Math.floor(item[o][2] / 4);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "Watt", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Watt").children("span.Enhance").children("span.mv").text(p);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.HP span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            p = Math.floor((item[o][2] - 70) / 4);
            if (p < 0) { p = 0; }
            p = p + 50;
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "HP", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.HP").children("span.Enhance").children("span.mv").text(p);

            var vp = $("div.UnitPart div#" + Part + " div.UnitDetail div.Damage span.Enhance span.vp").text();
            var vt = vp.substr(1, vp.indexOf("%") - 1);

            p = Math.floor(item[o][3] / 4);
            if (p < 0) { p = 0; }
            p = p + 3;
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Enhance").children("span.nv").text(enhancepoint(Part, "Damage", p, vt));
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.Damage").children("span.Enhance").children("span.mv").text(p);

            if (item[o][12] != "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").removeClass("hidden");
            }
            else if (item[o][12] == "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").addClass("hidden");
            }

            $("div.UnitPart div#" + Part).attr("target", o);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.SpecialInfo").html(item[o][12]);

            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.AttackType span").text(item[o][10]);
            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Speed span").text(plusminus(item[o][6]));
            $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Sight span").text(plusminus(item[o][9]));

            if (item[o][10] == "0" && item[o][6] == "0" && item[o][9] == "0") {
              $("div.UnitPart li#" + Part + "Extend").addClass("hidden");
            }
            else {
              $("div.UnitPart li#" + Part + "Extend").removeClass("hidden");
            }

            if (item[o][10] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.AttackType").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.AttackType").addClass("hidden"); }
            if (item[o][6] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Speed").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Speed").addClass("hidden"); }
            if (item[o][9] != "0") { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Sight").removeClass("hidden"); } else { $("div.UnitPart div#" + Part + " div.UnitDetail div.ExtendInfo div.Sight").addClass("hidden"); }
          }
          else if (Part == "AcP") {
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeC").children("div.Level").children("span.Level").text(item[o][0]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeC").children("div.Weight").children("span.Weight").text(item[o][1]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeC").children("div.Watt").children("span.Watt").text(item[o][2]);

            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.Damage").children("span.Damage").text(item[o][3]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.HP").children("span.HP").text(item[o][4]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.Armor").children("span.Armor").text(item[o][5]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.Speed").children("span.Speed").text(item[o][6]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.Delay").children("span.Delay").text(item[o][7]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.Range").children("span.Range").text(item[o][8]);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div.Sight").children("span.Sight").text(item[o][9]);

            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeD").children("div").each(function(){
              var tv = $(this).children("span").text();
              if (tv == 0) {
                $(this).addClass("hidden");
              }
              else if (tv > 0) {
                $(this).children("span").text("+ " + tv);
              }
              else if (tv < 0) {
                $(this).children("span").text("- " + tv.substr(1));
              }
            });

            if (item[o][2] < 0) {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeC").children("div.Watt").children("span.Watt").attr("style", "color: yellow");
            }
            else {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("div.typeC").children("div.Watt").children("span.Watt").attr("style", "");
            }

            if (item[o][12] != "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").removeClass("hidden");
            }
            else if (item[o][12] == "") {
              $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.Space").children("span.Special").addClass("hidden");
            }

            $("div.UnitPart div#" + Part).attr("target", o);
            $("div.UnitPart div#" + Part).children("div.UnitDetail").children("span.SpecialInfo").html(item[o][12]);
          }

          if (Part == "BP" || Part == "AP") {
            if (item[o][11] == "팔형") {
              var armtype = "ArmA";
            }
            else if (item[o][11] == "어깨형") {
              var armtype = "ArmS";
            }
            else if (item[o][11] == "탑형") {
              var armtype = "ArmT";
            }

            $("div.UnitPart div#" + Part).children("div.BlockArmType").attr("class", "BlockArmType " + armtype);
          }

          if ($("div.UnitPart div#BP").attr("target") != "0" && $("div.UnitPart div#AP").attr("target") != "0") {
            if (item[$("div.UnitPart div#BP").attr("target")][11] != item[$("div.UnitPart div#AP").attr("target")][11]) {
              $("div.UnitPart li#BP").addClass("unfit");
              $("div.UnitPart li#AP").addClass("unfit");
              var unfit = true;
            }
            else {
              $("div.UnitPart li#BP").removeClass("unfit");
              $("div.UnitPart li#AP").removeClass("unfit");
              var unfit = false;
            }
          }

          var w0 = $("div.UnitPart div#MP").children("div.UnitDetail").children("div.Weight").children("span.Weight").text();
          var w1 = $("div.UnitPart div#BP").children("div.UnitDetail").children("div.Weight").children("span.Weight").text();
          var w2 = $("div.UnitPart div#AP").children("div.UnitDetail").children("div.Weight").children("span.Weight").text();
          var w3 = $("div.UnitPart div#AcP").children("div.UnitDetail").children("div.typeC").children("div.Weight").children("span.Weight").text();
          var wx = w1 * 1 + w2 * 1 + w3 * 1;

          if (w0 > 0 && w0 < wx) {
            $("div.UnitPart li#MP").addClass("unfit");
            if (unfit == false) { unfit = true; }
          }
          else {
            $("div.UnitPart li#MP").removeClass("unfit");
          }

          var ncnt = 0;
          $("div.UnitPart div.Unit").each(function(){
            var t = $(this).children("div.UnitDetail").children("span.Nametag").children("span.Name").text();
            if (t.substr(t.length - 1) == "N") {
              ncnt = ncnt + 1;
            }
          });

          if (ncnt >= 2) {
            $("div.UnitPart div.Unit").each(function(){
              var t = $(this).children("div.UnitDetail").children("span.Nametag").children("span.Name").text();
              if (t.substr(t.length - 1) == "N") {
                $("div.UnitPart li#" + $(this).attr("id")).addClass("unfit");
              }
            });
            unfit = true;
          }

          if (item[$("div.UnitPart div#AP").attr("target")][13] == "아포칼립스" && w1 != 0 && w1 < 30) {
            $("div.UnitPart li#BP").addClass("unfit");
            $("div.UnitPart li#AP").addClass("unfit");
            unfit = true;
          }

          if (unfit == true) { $("div.unfit").removeClass("hidden"); }
          else { $("div.unfit").addClass("hidden"); }
        }

        function selectsubcore(Part, Subcore) {
          if (Subcore == "") {
            $("div.UnitPart div#" + Part + " div.UnitDetail div.SubCore span.SubCore").attr("target", "");
            $("div.UnitPart div#" + Part + " div.UnitDetail div.SubCore span.SubCore").text("");

            $("div.UnitPart div#" + Part + " div.BlockSubCore").addClass("hidden");
            $("div.UnitPart div#" + Part + " div.BlockSubCore").attr("value", "");
          }
          else {
            $("div.UnitPart div#" + Part + " div.UnitDetail div.SubCore span.SubCore").attr("target", Subcore);
            $("div.UnitPart div#" + Part + " div.UnitDetail div.SubCore span.SubCore").text("서브코어(" + Subcore + "): " + $("div#" + Part + " div.SubArea ul.SubCore li.Subcore.Code" + Subcore).attr("title").substr($("div#" + Part + " div.SubArea ul.SubCore li.Subcore.Code" + Subcore).attr("title").indexOf(":") + 2));

            $("div.UnitPart div#" + Part + " div.BlockSubCore").attr("value", Subcore);
            $("div.UnitPart div#" + Part + " div.BlockSubCore").attr("class", "BlockSubCore Code" + Subcore);
          }
        }
        
        $("div.Unit div.SubArea").click(function(){
          $(this).addClass("hidden");
          if ($(this).parent().children("ul.SubCore").hasClass("hidden")) {
            $(this).parent().children("ul.SubCore").removeClass("hidden");
          }
          $(this).parent().children("div.BlockSubCore").addClass("hidden");
          $(this).parent().children("div.BlockSubCore").attr("value", "");
          $(this).parent().children("div.BlockArmType").addClass("hidden");
        });
        $("ul.SubCore li.SubCore").click(function(){
          $(this).parent().parent().children("div.UnitDetail").children("div.SubCore").children("span.SubCore").attr("target", $(this).attr("value"));
          $(this).parent().parent().children("div.UnitDetail").children("div.SubCore").children("span.SubCore").text("서브코어(" + $(this).attr("value") + "): " + $(this).attr("title").substr($(this).attr("title").indexOf(":") + 2));
          $(this).parent("ul.SubCore").addClass("hidden");
          $(this).parent().parent().children("div.SubArea").removeClass("hidden");

          $(this).parent().parent().children("div.BlockSubCore").removeClass("hidden");
          $(this).parent().parent().children("div.BlockSubCore").attr("value", $(this).attr("value"));
          $(this).parent().parent().children("div.BlockArmType").removeClass("hidden");

          $(this).parent().parent().children("div.BlockSubCore").attr("class", "BlockSubCore Code" + $(this).attr("value"));

          refreshinfo();
        });
        $("ul.SubCore li.Cancel").click(function(){
          $(this).parent().parent().children("div.UnitDetail").children("div.SubCore").children("span.SubCore").attr("target", "");
          $(this).parent().parent().children("div.UnitDetail").children("div.SubCore").children("span.SubCore").text("");
          $(this).parent("ul.SubCore").addClass("hidden");
          $(this).parent().parent().children("div.SubArea").removeClass("hidden");

          $(this).parent().parent().children("div.BlockSubCore").removeClass("hidden");
          $(this).parent().parent().children("div.BlockSubCore").attr("value", "");
          $(this).parent().parent().children("div.BlockArmType").removeClass("hidden");

          $(this).parent().parent().children("div.BlockSubCore").attr("class", "BlockSubCore");

          refreshinfo();
        });

        function refreshinfo() {
          var proc = ["Watt", "HP", "Speed", "Delay", "Range", "Sight", "Damage", "Armor"];

          for (var x = 0; x < 8; x++) {
            var v1 = getinfo("MP", proc[x]);
            var v2 = getinfo("BP", proc[x]);
            var v3 = getinfo("AP", proc[x]);
            var v4 = getinfo("AcP", proc[x]);

            var p1 = getenhancedinfo("MP", proc[x]);
            var p2 = getenhancedinfo("BP", proc[x]);
            var p3 = getenhancedinfo("AP", proc[x]);

            var vo = v1 * 1 + v2 * 1 + v3 * 1 + v4 * 1;
            var po = p1 * 1 + p2 * 1 + p3 * 1;
            var vx = vo + po;

            $("div.UnitInfo li#Unit" + proc[x] + " span").text(vx);
          }

          processsubcore();
        }

        function getinfo(part, type) {
          if (part != "AcP") {
            if ($("div.UnitPart div#" + part).children("div.UnitDetail").children("div." + type).children("span." + type).length == 0) {
              var o = $("div.UnitPart div#" + part).attr("target");
              if (o == 0) { return 0; }
              if (type == "Speed") { return item[o][6]; }
              if (type == "Delay") { return item[o][7]; }
              if (type == "Range") { return item[o][8]; }
              if (type == "Sight") { return item[o][9]; }
              if (type == "Armor") { return item[o][5]; }
            }
            if (type != "Range") {
              var k = $("div.UnitPart div#" + part).children("div.UnitDetail").children("div." + type).children("span." + type).text();
              if (k == "") { k = 0; }
              return k
            }
            else {
              var k = $("div.UnitPart div#" + part).children("div.UnitDetail").children("div." + type).children("span." + type).text().substr($("div.UnitPart div#" + part).children("div.UnitDetail").children("div." + type).children("span." + type).text().indexOf("-") + 1);
              if (k == "") { k = 0; }
              return k
            }
          }
          else if (part == "AcP") {
            if (type == "Watt" || type == "Weight") {
              return $("div.UnitPart div#" + part).children("div.UnitDetail").children("div.typeC").children("div." + type).children("span." + type).text();
            }
            else {
              return $("div.UnitPart div#" + part).children("div.UnitDetail").children("div.typeD").children("div." + type).children("span." + type).text().replace(" ", "");
            }
          }
        }

        // echo 'item['.$x.'] = ['.$d["optlevel"].', '.$d["optweight"].', '.$d["optwatt"].', '.$d["optdamage"].', '.$d["opthp"].', '.$d["optarmor"].', '.$d["optspeed"].', '.$d["optdelay"].', "'.$d["optrange"].'", '.$d["optsight"].', "'.$d["optattacktype"].'", "'.$d["optarmtype"].'", "'.$d["optspecial"].'"];'.chr(10);
        function getenhancedinfo(part, type) {
          if (type != "Watt" && type != "HP" && type != "Damage") { return 0; }
          else {
            var tmp = $("div.UnitPart div#" + part).children("div.UnitDetail").children("div." + type).children("span.Enhance").children("span.mv").text();
            var tmp2 = $("div.UnitPart div#" + part).children("div.UnitDetail").children("div." + type).children("span.Enhance").children("span.vp").attr("value");

            var key = enhancepoint(part, type, tmp, tmp2);

            if (type == "Watt") {
              return "-" + key;
            }
            else {
              return key;
            }
          }
        }

        function processsubcore() {
          var geproc = 0;
          $("div.Unit div.BlockSubCore").each(function(){
            if ($(this).hasClass("CodeTa")) { $("div.UnitInfo li#UnitHP span").text($("div.UnitInfo li#UnitHP span").text() * 1 + 70); }
            if ($(this).hasClass("CodeGe")) {
              var gev = $(this).parent().children("div.UnitDetail").children("div.Watt").children("span.Watt").text();
              geproc = geproc + gev * 0.04;
            }
            if ($(this).hasClass("CodeCn")) { $("div.UnitInfo li#UnitArmor span").text($("div.UnitInfo li#UnitArmor span").text() * 1 + 5); }
            if ($(this).hasClass("CodeLe")) { $("div.UnitInfo li#UnitDelay span").text($("div.UnitInfo li#UnitDelay span").text() * 1 - 15); }
            if ($(this).hasClass("CodeLi")) { $("div.UnitInfo li#UnitWatt span").text($("div.UnitInfo li#UnitWatt span").text() * 1 - 6); }
            if ($(this).hasClass("CodeSc")) { $("div.UnitInfo li#UnitDamage span").text($("div.UnitInfo li#UnitDamage span").text() * 1 + 5); }
            if ($(this).hasClass("CodeSg")) {
              if ($(this).parent().attr("id") == "AP") {
                $("div.UnitInfo li#UnitRange span").text($("div.UnitInfo li#UnitRange span").text() * 1 + 2);
              }
              else {
                $("div.UnitInfo li#UnitRange span").text($("div.UnitInfo li#UnitRange span").text() * 1 + 1);
              }
            }
            if ($(this).hasClass("CodeCa")) { $("div.UnitInfo li#UnitSight span").text($("div.UnitInfo li#UnitSight span").text() * 1 + 3); }
            if ($(this).hasClass("CodePs")) { $("div.UnitInfo li#UnitSpeed span").text($("div.UnitInfo li#UnitSpeed span").text() * 1 + 5); }
          });

          if (geproc > 0) {
            var gx = Math.round($("div.UnitInfo li#UnitWatt span").text() - geproc * 1);
            $("div.UnitInfo li#UnitWatt span").text(gx);
          }

          processspecialeffects();
          makesureinfotextclean();
        }

        function processspecialeffects() {
          var o = $("div.UnitPart div#MP").attr("target");
          var info = [$("div.UnitInfo li#UnitWatt span").text(), $("div.UnitInfo li#UnitHP span").text(), $("div.UnitInfo li#UnitSpeed span").text(), $("div.UnitInfo li#UnitDelay span").text(), $("div.UnitInfo li#UnitRange span").text(), $("div.UnitInfo li#UnitSight span").text(), $("div.UnitInfo li#UnitDamage span").text(), $("div.UnitInfo li#UnitArmor span").text()];

          if (o == "19") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.1)); }
          if (o == "20") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.5)); }
          if (o == "3" || o == "13" || o == "15" || o == "18" || o == "23") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 + info[6] * 0.1)); }
          if (o == "32" || o == "34" || o == "36") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 + info[6] * 0.15)); }

          var o = $("div.UnitPart div#BP").attr("target");
          if (o == "88") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.05)); }
          if (o == "57") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.25)); }
          if (o == "48") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.3)); }
          if (o == "60" || o == "63") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.5)); }
          if (o == "70" || o == "84" || o == "86") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 + info[6] * 0.1)); }
          if (o == "83") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 + info[6] * 0.2)); }

          var o = $("div.UnitPart div#AP").attr("target");
          if (o == "137") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.1)); }
          if (o == "114") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.3)); }
          if (o == "97" || o == "102" || o == "121") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.5)); }

          var o = $("div.UnitPart div#AcP").attr("target");
          if (o == "192") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.3)); }
          if (o == "192") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 + info[6] * 0.3)); }

          if (o == "220") {
            $("div.UnitInfo li#UnitWatt span").text(Math.round($("div.UnitInfo li#UnitWatt span").text() * 1 + info[0] * 0.1));
            $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 + info[1] * 0.1));
            $("div.UnitInfo li#UnitSpeed span").text(Math.round($("div.UnitInfo li#UnitSpeed span").text() * 1 + info[2] * 0.1));
            $("div.UnitInfo li#UnitDelay span").text(Math.round($("div.UnitInfo li#UnitDelay span").text() * 1 + info[3] * 0.1));
            $("div.UnitInfo li#UnitRange span").text(Math.round($("div.UnitInfo li#UnitRange span").text() * 1 + info[4] * 0.1));
            $("div.UnitInfo li#UnitSight span").text(Math.round($("div.UnitInfo li#UnitSight span").text() * 1 + info[5] * 0.1));
            $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 + info[6] * 0.1));
            $("div.UnitInfo li#UnitArmor span").text(Math.round($("div.UnitInfo li#UnitArmor span").text() * 1 + info[7] * 0.1));
          }

          // ----------- last -----------

          var o = $("div.UnitPart div#MP").attr("target");
          if (o == "23") {
            $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 - info[1] * 0.1));
          }

          var o = $("div.UnitPart div#AcP").attr("target");
          if (o == "179") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 - info[1] * 0.1)); }
          if (o == "190") { $("div.UnitInfo li#UnitHP span").text(Math.round($("div.UnitInfo li#UnitHP span").text() * 1 - info[1] * 0.2)); }

          if (o == "190") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 - info[6] * 0.1)); }
          if (o == "179") { $("div.UnitInfo li#UnitDamage span").text(Math.round($("div.UnitInfo li#UnitDamage span").text() * 1 - info[6] * 0.2)); }
        }

        function makesureinfotextclean() {
          if ($("div.UnitInfo li#UnitWatt span").text() < 0) { $("div.UnitInfo li#UnitWatt span").text("0"); }
          if ($("div.UnitInfo li#UnitHP span").text() < 0) { $("div.UnitInfo li#UnitHP span").text("0"); }
          if ($("div.UnitInfo li#UnitSpeed span").text() < 0) { $("div.UnitInfo li#UnitSpeed span").text("0"); }
          if ($("div.UnitInfo li#UnitSpeed span").text() > 120) { $("div.UnitInfo li#UnitSpeed span").text("120"); }
          if ($("div.UnitInfo li#UnitDelay span").text() < 50) { $("div.UnitInfo li#UnitDelay span").text("50"); }
          if ($("div.UnitInfo li#UnitRange span").text() < 0) { $("div.UnitInfo li#UnitRange span").text("0"); }
          if ($("div.UnitInfo li#UnitSight span").text() < 0) { $("div.UnitInfo li#UnitSight span").text("0"); }
          if ($("div.UnitInfo li#UnitDamage span").text() < 0) { $("div.UnitInfo li#UnitDamage span").text("0"); }
          if ($("div.UnitInfo li#UnitArmor span").text() < 0) { $("div.UnitInfo li#UnitArmor span").text("0"); }
        }

        $("div.UnitDetail span.Space span.Special").click(function(){
          $(this).parent().parent().children("div").each(function(){
            if (!$(this).hasClass("SubCore")) {
              $(this).addClass("hidden");
            }
          });

          $(this).addClass("hidden");
          $(this).parent().children("span.Normal").removeClass("hidden");
          $(this).parent().parent().children("span.SpecialInfo").removeClass("hidden");
          $(this).parent().parent().children("div.SubCore").addClass("hidden");
        });

        $("div.UnitDetail span.Space span.Normal").click(function(){
          $(this).parent().parent().children("div").each(function(){
            if (!$(this).hasClass("SubCore")) {
              $(this).removeClass("hidden");
            }
          });

          $(this).addClass("hidden");
          $(this).parent().children("span.Special").removeClass("hidden");
          $(this).parent().parent().children("span.SpecialInfo").addClass("hidden");
          $(this).parent().parent().children("div.SubCore").removeClass("hidden");
        });

        function plusminus(val) {
          var t = "t" + val;
          if (val > 0) {
            return "+ " + val; 
          }
          else if (val < 0) {
            return "- " + t.substr(2);
          }
          else if (val == 0) {
            return 0;
          }
        }

        $("div.Share span.Share").click(function(){
          $.post("http://nova1492.uu.gl/", {
            act: "Share",
            Part: $("div.UnitPart div#MP").attr("target") + "/" + $("div.UnitPart div#BP").attr("target") + "/" + $("div.UnitPart div#AP").attr("target") + "/" + $("div.UnitPart div#AcP").attr("target"),
            Enhance: $("div.UnitPart div#MP div.UnitDetail div.Watt span.Enhance span.vp").attr("value") + "/" + $("div.UnitPart div#MP div.UnitDetail div.HP span.Enhance span.vp").attr("value") + "/" + $("div.UnitPart div#MP div.UnitDetail div.Damage span.Enhance span.vp").attr("value") + "|" + $("div.UnitPart div#BP div.UnitDetail div.Watt span.Enhance span.vp").attr("value") + "/" + $("div.UnitPart div#BP div.UnitDetail div.HP span.Enhance span.vp").attr("value") + "/" + $("div.UnitPart div#BP div.UnitDetail div.Damage span.Enhance span.vp").attr("value") + "|" + $("div.UnitPart div#AP div.UnitDetail div.Watt span.Enhance span.vp").attr("value") + "/" + $("div.UnitPart div#AP div.UnitDetail div.HP span.Enhance span.vp").attr("value") + "/" + $("div.UnitPart div#AP div.UnitDetail div.Damage span.Enhance span.vp").attr("value"),
            Subcore: $("div.UnitPart div#MP div.BlockSubCore").attr("value") + "/" + $("div.UnitPart div#BP div.BlockSubCore").attr("value") + "/" + $("div.UnitPart div#AP div.BlockSubCore").attr("value")
          },
          function(data,status) {
            if (data.rtncode == "0") {
              window.alert('잘못된 요청입니다.');
              return false;
            }
            else if (data.rtncode == "1") {
              $("div.Share input.ShareLink").removeClass("hidden");
              $("div.Share input.ShareLink").attr("value", data.link);
            }
            else if (data.rtncode == "2") {
              window.alert(data.msg);
            }
          }, "json");
        });

        <?php
        if ($getcode == "success") {
        ?>
        
        selectpart("MP", "<?=$Part[0]?>");
        selectpart("BP", "<?=$Part[1]?>");
        selectpart("AP", "<?=$Part[2]?>");
        selectpart("AcP", "<?=$Part[3]?>");

        enhanceinput("MP", "Watt", "<?=$MPE[0]?>");
        enhanceinput("MP", "HP", "<?=$MPE[1]?>");
        enhanceinput("MP", "Damage", "<?=$MPE[2]?>");

        enhanceinput("BP", "Watt", "<?=$BPE[0]?>");
        enhanceinput("BP", "HP", "<?=$BPE[1]?>");
        enhanceinput("BP", "Damage", "<?=$BPE[2]?>");

        enhanceinput("AP", "Watt", "<?=$APE[0]?>");
        enhanceinput("AP", "HP", "<?=$APE[1]?>");
        enhanceinput("AP", "Damage", "<?=$APE[2]?>");

        selectsubcore("MP", "<?=$Subcore[0]?>");
        selectsubcore("BP", "<?=$Subcore[1]?>");
        selectsubcore("AP", "<?=$Subcore[2]?>");
        
        refreshinfo();
        <?php
        }
        ?>
      });
    </script>
  </head>
  <body bgcolor="black">
    <div class="main">
      <div class="UseInfo hidden">
        <p>&nbsp;</p>
        <b>
          <p>제작 Secure</p>
          <p>contact: secure@sogang.ac.kr</p>
        </b>
        <p>&nbsp;</p>
        <p>---------------------------------</p>
        <p>&nbsp;</p>
        <b><p>기능설명</p></b>
        <p>&nbsp;</p>
        <p>- MP, BP, AP, AcP를 각각 골라 유닛을 시뮬레이팅 할 수 있습니다.</p>
        <p>&nbsp;</p>
        <p>- MP, BP, AP, AcP에 각각 마우스를 올리고</p>
        <p>키보드 방향키(↑, ↓)를 눌러 목록을 볼 수 있습니다.</p>
        <p>또는, 새로 추가된 스크롤 버튼을 이용 해 주세요.</p>
        <p>&nbsp;</p>
        <p>- Watt, 체력, 공격 부분을 클릭한 뒤, 강화수치를 변경할 수 있습니다.</p>
        <p>(엔터 키를 누르세요)</p>
        <p>&nbsp;</p>
        <p>- 유닛의 이미지를 누른 뒤 서브코어를 달 수 있습니다.</p>
      </div>
      <div class="UpdateLog hidden">
        <p align="center">&nbsp;</p>
        <b align="center">
          <p style="margin: 0;">제작 Secure</p>
          <p style="margin: 0;">contact: secure@sogang.ac.kr</p>
        </b>
        <p>&nbsp;</p>
        <p align="center" style="margin: 0;">---------------------------------</p>
        <p>&nbsp;</p>
        <b align="center" style="margin: 0;"><p>업데이트 기록</p></b>
        <p>&nbsp;</p>
        <p>2016-01-02 17:46 | 특수 효과 중 '공격, 방어'에 대해서 1차 적용</p>
        <p>2016-01-02 19:16 | 특수 효과 전체 적용 완료</p>
        <p>2016-01-02 19:36 | N템 중복 부적합 처리</p>
        <p>2016-01-03 14:36 | <b>확장 성능 추가, 누락된 이미지 추가</b></p>
        <p>2016-01-03 19:56 | 잘못된 조합 관련 버그 픽스</p>
        <p>2016-01-04 13:16 | <b>초신성 추가, 공유 기능 추가</b></p>
        <p>2016-01-04 14:26 | 스크롤 버튼 추가</p>
        <p>2016-01-06 19:38 | 갤로퍼N 특수 효과 적용</p>
        <p>2016-01-06 19:56 | 공유 기능 쿨타임 추가(10초)</p>
        <p>2016-01-07 21:08 | 계산 순서 변경 (서브코어 -> 특수효과 적용)</p>
        <p>2016-01-08 18:10 | 갤로퍼N 효과 [시야 -3] -> [사거리 -3] 수정</p>
        <p>2016-01-09 18:26 | 아포칼립스 특수효과 적용 (몸통 무게 30 이상)</p>
        <p>2016-02-02 20:54 | 부품 밸런싱 업데이트 적용</p>
        <p>2016-02-26 20:24 | 부품 밸런싱 업데이트 적용</p>
        <p>2016-02-29 01:53 | 제미늄 처리 수정</p>
        <p>2016-04-17 23:10 | 부품 밸런싱 업데이트 적용</p>
        <p>2016-04-18 02:40 | 부품 밸런싱 업데이트 적용(기존)</p>
        <p>2016-05-04 01:24 | 사지타리움 '텍스트' 사거리 +2 증가로 수정</p>
      </div>
      <div class="UnitPart">
        <li id="MP" class="PartView default"></li><li id="MPExtend" class="extend hidden"></li>
        <li id="BP" class="PartView default"></li><li id="BPExtend" class="extend hidden"></li>
        <li id="AP" class="PartView default"></li><li id="APExtend" class="extend hidden"></li>
        <li id="AcP" class="PartView default"></li><li id="AcPExtend" class="extend hidden"></li>
        <div class="unfit hidden">[!] 조합 부적합</div>
        <div id="MP" class="Unit" target="0">
          <div class="BlockSubCore" value=""></div>
          <div class="SubArea"></div>
          <ul class="SubCore hidden">
            <li class="SubCore CodeAr" title="에어리움: 체력리젠 +2%" value="Ar"></li>
            <li class="SubCore CodeTa" title="타우리움: 체력 +70" value="Ta"></li>
            <li class="SubCore CodeGe" title="제미늄: 와트 -4%" value="Ge"></li>
            <li class="SubCore CodeCn" title="켄서늄: 방어 +5" value="Cn"></li>
            <li class="SubCore CodeLe" title="레오늄: 연사 -15" value="Le"></li>
            <li class="SubCore CodeVi" title="비르늄: 방어무시 +7" value="Vi"></li>
            <li class="SubCore CodeLi" title="리브리움: 와트 -6" value="Li"></li>
            <li class="SubCore CodeSc" title="스콜피움: 공격 +5" value="Sc"></li>
            <li class="SubCore CodeSg" title="사지타리움: 사거리 +1" value="Sg"></li>
            <li class="SubCore CodeCa" title="카프리움: 시야 +3" value="Ca"></li>
            <li class="SubCore CodeAq" title="아쿠아리움: 스플범위 +1" value="Aq"></li>
            <li class="SubCore CodePs" title="피스케늄: 속도 +5" value="Ps"></li>
            <li class="Cancel">[미적용]</li>
          </ul>
          <div class="UnitDetail">
            <span class="Space"><span class="Special hidden"></span><span class="Normal hidden"></span></span><span class="Nametag"><span class="Name hidden"></span><span class="Star hidden"></span></span>
            <span class="SpecialInfo hidden"></span>
            <div class="Level typeA hidden"><span class="Level"></span></div>
            <div class="Weight typeA WA R hidden"><span class="Weight">0</span></div>
            <div class="Speed typeA hidden"><span class="Speed"></span></div>
            <div class="Armor typeA R hidden"><span class="Armor"></span></div>
            <div class="Watt Extend typeB hidden"><span class="Watt"></span><span class="Enhance hidden"><span class="oper">-</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput Watt" type="text" maxlength="3" part="MP" target="Watt">%</span></div>
            <div class="HP Extend typeB hidden"><span class="HP"></span><span class="Enhance hidden"><span class="oper">+</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput" type="text" maxlength="3" part="MP" target="HP">%</span></div>
            <div class="Damage Extend typeB hidden"><span class="Damage"></span><span class="Enhance hidden"><span class="oper">+</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput" type="text" maxlength="3" part="MP" target="Damage">%</span></div>
            <div class="SubCore typeB hidden"><span class="SubCore" target=""></span></div>
            <div class="ExtendInfo">
              <div class="Delay hidden"><span class="Delay" style="color: yellow;"></span></div>
              <div class="Range hidden"><span class="Range" style="color: yellow;"></span></div>
              <div class="Sight hidden"><span class="Sight" style="color: yellow;"></span></div>
            </div>
          </div>
        </div>
        <div id="BP" class="Unit" target="0">
          <div class="BlockSubCore" value=""></div>
          <div class="BlockArmType"></div>
          <div class="SubArea"></div>
          <ul class="SubCore hidden">
            <li class="SubCore CodeAr" title="에어리움: 체력리젠 +2%" value="Ar"></li>
            <li class="SubCore CodeTa" title="타우리움: 체력 +70" value="Ta"></li>
            <li class="SubCore CodeGe" title="제미늄: 와트 -4%" value="Ge"></li>
            <li class="SubCore CodeCn" title="켄서늄: 방어 +5" value="Cn"></li>
            <li class="SubCore CodeLe" title="레오늄: 연사 -15" value="Le"></li>
            <li class="SubCore CodeVi" title="비르늄: 방어무시 +7" value="Vi"></li>
            <li class="SubCore CodeLi" title="리브리움: 와트 -6" value="Li"></li>
            <li class="SubCore CodeSc" title="스콜피움: 공격 +5" value="Sc"></li>
            <li class="SubCore CodeSg" title="사지타리움: 사거리 +1" value="Sg"></li>
            <li class="SubCore CodeCa" title="카프리움: 시야 +3" value="Ca"></li>
            <li class="SubCore CodeAq" title="아쿠아리움: 스플범위 +1" value="Aq"></li>
            <li class="SubCore CodePs" title="피스케늄: 속도 +5" value="Ps"></li>
            <li class="Cancel">[미적용]</li>
          </ul>
          <div class="UnitDetail">
            <span class="Space"><span class="Special hidden"></span><span class="Normal hidden"></span></span><span class="Nametag"><span class="Name hidden"></span><span class="Star hidden"></span></span>
            <span class="SpecialInfo hidden"></span>
            <div class="Level typeA hidden"><span class="Level"></span></div>
            <div class="Weight typeA WB R hidden"><span class="Weight">0</span></div>
            <div class="Sight typeA hidden"><span class="Sight"></span></div>
            <div class="Armor typeA R hidden"><span class="Armor"></span></div>
            <div class="Watt Extend typeB hidden"><span class="Watt"></span><span class="Enhance hidden"><span class="oper">-</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput Watt" type="text" maxlength="3" part="BP" target="Watt">%</span></div>
            <div class="HP Extend typeB hidden"><span class="HP"></span><span class="Enhance hidden"><span class="oper">+</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput" type="text" maxlength="3" part="BP" target="HP">%</span></div>
            <div class="Damage Extend typeB hidden"><span class="Damage"></span><span class="Enhance hidden"><span class="oper">+</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput" type="text" maxlength="3" part="BP" target="Damage">%</span></div>
            <!--
            <div class="Watt Extend typeB hidden"><span class="Watt"></span></div>
            <div class="HP Extend typeB hidden"><span class="HP"></span></div>
            <div class="Damage Extend typeB hidden"><span class="Damage"></span></div>
            -->
            <div class="SubCore typeB hidden"><span class="SubCore" target=""></span></div>
            <div class="ExtendInfo">
              <div class="Delay hidden"><span class="Delay" style="color: yellow;"></span></div>
              <div class="Speed hidden"><span class="Speed" style="color: yellow;"></span></div>
              <div class="Sight hidden"><span class="Sight" style="color: yellow;"></span></div>
            </div>
          </div>
        </div>
        <div id="AP" class="Unit" target="0">
          <div class="BlockSubCore" value=""></div>
          <div class="BlockArmType"></div>
          <div class="SubArea"></div>
          <ul class="SubCore hidden">
            <li class="SubCore CodeAr" title="에어리움: 체력리젠 +2%" value="Ar"></li>
            <li class="SubCore CodeTa" title="타우리움: 체력 +70" value="Ta"></li>
            <li class="SubCore CodeGe" title="제미늄: 와트 -4%" value="Ge"></li>
            <li class="SubCore CodeCn" title="켄서늄: 방어 +5" value="Cn"></li>
            <li class="SubCore CodeLe" title="레오늄: 연사 -15" value="Le"></li>
            <li class="SubCore CodeVi" title="비르늄: 방어무시 +7" value="Vi"></li>
            <li class="SubCore CodeLi" title="리브리움: 와트 -6" value="Li"></li>
            <li class="SubCore CodeSc" title="스콜피움: 공격 +5" value="Sc"></li>
            <li class="SubCore CodeSg" title="사지타리움: 사거리 +2" value="Sg"></li>
            <li class="SubCore CodeCa" title="카프리움: 시야 +3" value="Ca"></li>
            <li class="SubCore CodeAq" title="아쿠아리움: 스플범위 +1" value="Aq"></li>
            <li class="SubCore CodePs" title="피스케늄: 속도 +5" value="Ps"></li>
            <li class="Cancel">[미적용]</li>
          </ul>
          <div class="UnitDetail">
            <span class="Space"><span class="Special hidden"></span><span class="Normal hidden"></span></span><span class="Nametag"><span class="Name hidden"></span><span class="Star hidden"></span></span>
            <span class="SpecialInfo hidden"></span>
            <div class="Level typeA hidden"><span class="Level"></span></div>
            <div class="Weight typeA WB R hidden"><span class="Weight">0</span></div>
            <div class="Range typeA hidden"><span class="Range"></span></div>
            <div class="Delay typeA R hidden"><span class="Delay"></span></div>
            <div class="Watt Extend typeB hidden"><span class="Watt"></span><span class="Enhance hidden"><span class="oper">-</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput Watt" type="text" maxlength="3" part="AP" target="Watt">%</span></div>
            <div class="HP Extend typeB hidden"><span class="HP"></span><span class="Enhance hidden"><span class="oper">+</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput" type="text" maxlength="3" part="AP" target="HP">%</span></div>
            <div class="Damage Extend typeB hidden"><span class="Damage"></span><span class="Enhance hidden"><span class="oper">+</span><span class="nv"></span><span class="slash">/</span><span class="mv"></span><span class="vp" value="0">(0%)</span></span><span class="EnhanceInput hidden">: <input class="EnhanceInput" type="text" maxlength="3" part="AP" target="Damage">%</span></div>
            <div class="SubCore typeB hidden"><span class="SubCore" target=""></span></div>
            <div class="ExtendInfo">
              <div class="AttackType hidden"><span class="AttackType" style="color: red; font-size: 8pt;"></span></div>
              <div class="Speed hidden"><span class="Speed" style="color: yellow;"></span></div>
              <div class="Sight hidden"><span class="Sight" style="color: yellow;"></span></div>
            </div>
          </div>
        </div>
        <div id="AcP" class="Unit" target="0">
          <div class="UnitDetail">
            <span class="Space"><span class="Special hidden"></span><span class="Normal hidden"></span></span><span class="Nametag"><span class="Name hidden"></span></span>
            <span class="SpecialInfo hidden"></span>
            <div class="typeC">
              <div class="Level typeA hidden"><span class="Level"></span></div>
              <div class="Watt typeA hidden"><span class="Watt"></span></div>
              <div class="Weight typeA WB hidden"><span class="Weight">0</span></div>
            </div>
            <div class="typeD">
              <div class="Damage typeA hidden"><span class="Damage" style="color: yellow;"></span></div>
              <div class="HP typeA hidden"><span class="HP" style="color: yellow;"></span></div>
              <div class="Armor typeA hidden"><span class="Armor" style="color: yellow;"></span></div>
              <div class="Speed typeA hidden"><span class="Speed" style="color: yellow;"></span></div>
              <div class="Delay typeA hidden"><span class="Delay" style="color: yellow;"></span></div>
              <div class="Range typeA hidden"><span class="Range" style="color: yellow;"></span></div>
              <div class="Sight typeA hidden"><span class="Sight" style="color: yellow;"></span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="UnitList">
        <ul class="MP" order="0">
          <li id="MP0" class="MP highlight" type="MP" order="0"><span class="sl" style="float: left;">[미선택]</span><span class="sr" style="float: right;"></span></li>
          <?php
          $cnt = 0;
          $q = mysqli_query($con, "SELECT * FROM novaitem WHERE `type` = 'MP'");
          while ($d = mysqli_fetch_array($q)) {
            $cnt++;
            if ($cnt >= 6) {
              echo '<li id="MP'.$cnt.'" class="MP hidden" type="MP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
            else {
              echo '<li id="MP'.$cnt.'" class="MP" type="MP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
          }
          ?>
        </ul>
        <div style="position: absolute; left: 192px; top: 24px;">38</div>
        <div class="scrollup" style="position: absolute; left: 188px; top: 64px;" target="MP" order="0"></div>
        <div class="scrolldown" style="position: absolute; left: 188px; top: 94px;" target="MP" order="0"></div>
        <ul class="BP" order="1">
          <li id="BP0" class="BP highlight" type="BP" order="0"><span class="sl" style="float: left;">[미선택]</span><span class="sr" style="float: right;"></span></li>
          <?php
          $cnt = 0;
          $q = mysqli_query($con, "SELECT * FROM novaitem WHERE `type` = 'BP'");
          while ($d = mysqli_fetch_array($q)) {
            $cnt++;
            if ($cnt >= 6) {
              echo '<li id="BP'.$cnt.'" class="BP hidden" type="BP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
            else {
              echo '<li id="BP'.$cnt.'" class="BP" type="BP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
          }
          ?>
        </ul>
        <div style="position: absolute; left: 404px; top: 24px;">52</div>
        <div class="scrollup" style="position: absolute; left: 400px; top: 64px;" target="BP" order="1"></div>
        <div class="scrolldown" style="position: absolute; left: 400px; top: 94px;" target="BP" order="1"></div>
        <ul class="AP" order="2">
          <li id="AP0" class="AP highlight" type="AP" order="0"><span class="sl" style="float: left;">[미선택]</span><span class="sr" style="float: right;"></span></li>
          <?php
          $cnt = 0;
          $q = mysqli_query($con, "SELECT * FROM novaitem WHERE `type` = 'AP'");
          while ($d = mysqli_fetch_array($q)) {
            $cnt++;
            if ($cnt >= 6) {
              echo '<li id="AP'.$cnt.'" class="AP hidden" type="AP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
            else {
              echo '<li id="AP'.$cnt.'" class="AP" type="AP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
          }
          ?>
        </ul>
        <div style="position: absolute; left: 192px; top: 188px;">60</div>
        <div class="scrollup" style="position: absolute; left: 188px; top: 228px;" target="AP" order="2"></div>
        <div class="scrolldown" style="position: absolute; left: 188px; top: 258px;" target="AP" order="2"></div>
        <ul class="AcP" order="3">
          <li id="AcP0" class="AcP highlight" type="AcP" order="0"><span class="sl" style="float: left;">[미선택]</span><span class="sr" style="float: right;"></span></li>
          <?php
          $cnt = 0;
          $q = mysqli_query($con, "SELECT * FROM novaitem WHERE `type` = 'AcP'");
          while ($d = mysqli_fetch_array($q)) {
            $cnt++;
            if ($cnt >= 6) {
              echo '<li id="AcP'.$cnt.'" class="AcP hidden" type="AcP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
            else {
              echo '<li id="AcP'.$cnt.'" class="AcP" type="AcP" order="'.$cnt.'"><span class="sl" style="float: left;">'.$d["name"].'</span><span class="sr" style="float: right;">'.$d["cost"].'</span></li>';
            }
          }
          ?>
        </ul>
        <div style="position: absolute; left: 404px; top: 188px;">69</div>
        <div class="scrollup" style="position: absolute; left: 400px; top: 228px;" target="AcP" order="3"></div>
        <div class="scrolldown" style="position: absolute; left: 400px; top: 258px;" target="AcP" order="3"></div>
      </div>
      <div class="UnitInfo">
        <li id="UnitWatt"><span>0</span></li>
        <li id="UnitHP"><span>0</span></li>
        <li id="UnitSpeed"><span>0</span></li>
        <li id="UnitDelay"><span>0</span></li>
        <li id="UnitRange"><span>0</span></li>
        <li id="UnitSight"><span>0</span></li>
        <li id="UnitDamage"><span>0</span></li>
        <li id="UnitArmor"><span>0</span></li>
      </div>
      <div class="Share"><span class="Share" title="조립한 유닛을 링크로 공유할 수 있습니다.">공유하기</span> <input class="ShareLink hidden" type="text" value="http://nova1492.uu.gl/ExGb7w"></div>
      <div class="ShareResult"><?php if ($getcode == "fail") { echo '<font style="color: red !important">'.$_GET["code"].': 이 코드는 올바른 코드가 아닙니다.</font>'; } else if ($getcode == "success") { echo '<font style="color: lightgreen;">코드를 불러왔습니다.</font>'; } ?></div>
    </div>
    <div class="Info">
      <p align="center">Image Source Link <a href="http://cafe.naver.com/mg2/182784" target="_blank">http://cafe.naver.com/mg2/182784</a></p>
      <p align="center"><span id="info" style="color: cyan;">→ How to Use ←</span></p>
      <p align="center"><span id="updatelog" style="color: gray;">→ Update Log ←</span></p>
      <p align="center">페이지 오류를 정상화했습니다. 이용에 불편을 드려 죄송합니다... - 2016-01-04 23:36</p>
      <p align="center">3월 2일부터 접속이 되지 않던 문제가 해결되었습니다 (DB오류) - 2016-03-21 23:52</p>
      <p align="center">현재 적용되어 있는 부품 밸런싱 업데이트: 20160414</p>
	  <p align="center">Powered by <a href="http://modaweb.kr" style="font-weight:bold;">MODAWEB</a>.</p>
    </div>
  </body>
</html>