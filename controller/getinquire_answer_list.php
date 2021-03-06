<?php
require_once "../app.php";

/**
 * getBoard.php (현 파일)은 db로 부터 board 테이블과 member 테이블을 조인하여 반환된 레코드를
 * json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// p.406 참조 php에서의 header() 함수는 다운로드할 파일의 정보를 클라이언트 브라우저에게 알려주는 기능을 함

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// date(날짜)컬럼을 기준으로 내림차순 정렬
$db->orderBy('requestDate', "DESC");

$requestNum = $_POST["accountnum"];

$db->where ("requestNum" , $requestNum);

$board = $db->get('inquire');

$boardCount = $db->count;

// 반환된 레코드를 result 배열에 저장
$result['boardCount'] = $boardCount;
$result['result_data'] = $board;
$result['error'] = false;


// PHP 5.2 버전 이상부터는 JSON Parser를 기본 내장하고 있음. Rest Api 의 표준 형식.
//    - json_decode : JSON 오브젝트 -> PHP Array 또는 Object 변환
//    - json_encode : PHP Array 또는 Object -> JSON 오브젝트 변환
//
// PHP JSON 관련 Encode 작업 중에는 한글 깨짐에 주의. (주로 JSON_UNESCAPED_UNICODE)로 해결
echo json_encode($result);