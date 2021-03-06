-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- 생성 시간: 17-03-17 02:23
-- 서버 버전: 10.0.27-MariaDB-0ubuntu0.16.04.1
-- PHP 버전: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `nova`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `novacode`
--

CREATE TABLE `novacode` (
  `no` int(11) NOT NULL,
  `CODE` char(10) NOT NULL,
  `Part` char(16) NOT NULL,
  `Enhance` char(128) NOT NULL,
  `Subcore` char(16) NOT NULL,
  `IP` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 테이블 구조 `novaitem`
--

CREATE TABLE `novaitem` (
  `no` int(11) NOT NULL,
  `type` char(11) NOT NULL,
  `name` char(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `optlevel` int(11) NOT NULL,
  `optweight` int(11) NOT NULL,
  `optwatt` int(11) NOT NULL,
  `optdamage` int(11) NOT NULL,
  `opthp` int(11) NOT NULL,
  `optarmor` int(11) NOT NULL,
  `optspeed` int(11) NOT NULL,
  `optdelay` int(11) NOT NULL,
  `optrange` char(11) NOT NULL,
  `optsight` int(11) NOT NULL,
  `optattacktype` char(11) NOT NULL,
  `optarmtype` char(11) NOT NULL,
  `optspecial` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `novaitem`
--

INSERT INTO `novaitem` (`no`, `type`, `name`, `cost`, `optlevel`, `optweight`, `optwatt`, `optdamage`, `opthp`, `optarmor`, `optspeed`, `optdelay`, `optrange`, `optsight`, `optattacktype`, `optarmtype`, `optspecial`) VALUES
(1, 'MP', '로드런너', 1000, 1, 50, 60, 0, 0, 0, 100, 0, '0', 0, '', '', '스플레쉬 데미지 30%를 감소 시킵니다.'),
(2, 'MP', '토들러', 1000, 1, 70, 70, 0, 0, -3, 80, 0, '0', 0, '', '', '스플레쉬 데미지 40%를 감소 시킵니다.'),
(3, 'MP', '캔터', 1000, 1, 100, 70, 0, 0, 0, 55, 0, '0', 0, '', '', '유닛의 공격력 10% 상승 시킵니다.'),
(4, 'MP', '토들러N', 10000, 1, 70, 70, 0, 0, -3, 80, 0, '0', 0, '', '', '스플레쉬 데미지 60%를 감소 시킵니다.'),
(5, 'MP', '캐터필러', 1000, 8, 85, 70, 0, 0, 5, 70, 0, '0', 0, '', '', ''),
(6, 'MP', '패트롤', 1000, 20, 35, 110, 0, 0, 0, 110, 0, '0', 3, '', '', ''),
(7, 'MP', '패트롤N', 10000, 20, 40, 110, 0, 0, 0, 110, 0, '0', 3, '', '', ''),
(8, 'MP', '키위', 5000, 26, 65, 70, 0, 0, -7, 90, 0, '0', 0, '', '', '스플레쉬 데미지 30%를 감소 시킵니다.'),
(9, 'MP', '워커', 5000, 31, 90, 100, 0, 0, 0, 90, 0, '0', 0, '', '', '스플레쉬 데미지 30%를 감소 시킵니다.'),
(10, 'MP', '워커N', 20000, 31, 90, 100, 0, 0, -5, 90, 0, '0', 0, '', '', '스플레쉬 데미지 50%를 감소 시킵니다.'),
(11, 'MP', '호버', 5000, 36, 130, 180, 0, 0, -5, 75, 0, '0', 0, '', '', '체력리젠 +2%'),
(12, 'MP', '코벳', 5000, 40, 45, 140, 0, 0, 0, 100, 0, '0', 0, '', '', ''),
(13, 'MP', '앰블러', 10000, 41, 120, 150, 0, 0, 0, 60, -25, '0', 0, '', '', '유닛의 공격력 10% 상승 시킵니다.'),
(14, 'MP', '스트라이더', 10000, 56, 100, 120, 0, 0, 5, 80, 0, '0', 3, '', '', ''),
(15, 'MP', '스트라이더N', 30000, 56, 100, 120, 0, 0, 0, 90, 0, '0', 3, '', '', '유닛의 공격력 10% 상승 시킵니다.'),
(16, 'MP', '프리깃', 10000, 60, 50, 160, 0, 0, 0, 95, 0, '0', 0, '', '', ''),
(17, 'MP', '크롤러', 20000, 61, 120, 220, 0, 0, 20, 85, 0, '0', 0, '', '', ''),
(18, 'MP', '크롤러N', 40000, 61, 120, 200, 0, 0, 15, 90, 0, '0', 0, '', '', '유닛의 공격력 10% 상승 시킵니다.'),
(19, 'MP', '갤로퍼', 20000, 66, 110, 160, 0, 0, 0, 85, 0, '0', 0, '', '', '유닛의 체력을 10% 상승 시킵니다.'),
(20, 'MP', '갤로퍼N', 40000, 66, 110, 160, 0, 0, 0, 85, 0, '-3', 0, '', '', '조립시 체력을 50% 상승 시킵니다.'),
(21, 'MP', '쿼더', 20000, 76, 95, 180, 0, 0, 0, 90, 0, '5', 5, '', '', ''),
(22, 'MP', '크루저', 20000, 80, 65, 220, 0, 0, 0, 85, 0, '0', 0, '', '', ''),
(23, 'MP', '크루저N', 40000, 80, 65, 220, 0, 0, 0, 85, 0, '0', 0, '', '', '이동 감소 효과가 발생하였을 경우 해당 시간을 절반으로 줄어들게 합니다.</br></br>조립시 공격력 10%가 상승합니다.</br></br>조립 후 최종 체력 10% 감소합니다.'),
(24, 'MP', '스플리터', 30000, 86, 105, 280, 0, 0, 0, 110, 0, '0', 0, '', '', ''),
(25, 'MP', '오프로더', 40000, 91, 140, 300, 0, 0, 15, 90, 0, '0', 0, '', '', ''),
(26, 'MP', '스파이더', 40000, 96, 150, 280, 0, 0, 0, 65, -50, '5', 0, '', '', ''),
(27, 'MP', '하이로더', 40000, 97, 125, 300, 0, 0, 5, 95, 0, '0', 0, '', '', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(28, 'MP', '하이로더N', 80000, 97, 125, 300, 0, 0, 0, 95, 0, '3', 0, '', '', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(29, 'MP', '탱커', 40000, 98, 125, 350, 0, 0, 15, 85, 0, '0', 5, '', '', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(30, 'MP', '스타쉽', 50000, 100, 80, 400, 0, 0, 0, 80, 0, '0', 0, '', '', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(31, 'MP', '카소와리', 50000, 100, 80, 130, 0, 0, -5, 95, 0, '3', 0, '', '', '스플레쉬 데미지 30%를 감소 시킵니다.'),
(32, 'MP', '옵테릭스', 50000, 102, 75, 110, 0, 0, -2, 95, 0, '0', 0, '', '', '유닛의 공격력 15% 상승 시킵니다.'),
(33, 'MP', '포퍼스', 50000, 102, 75, 300, 0, 0, 0, 85, 0, '0', 3, '', '', '5초마다 유닛의 최대 체력 2%를 자동 회복 합니다.'),
(34, 'MP', '델피누스', 5000, 102, 115, 350, 0, 0, 0, 90, 0, '0', 0, '', '', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.</br></br>유닛의 공격력 15% 상승 시킵니다.'),
(35, 'MP', '라운시', 50000, 103, 95, 200, 0, 0, 15, 95, 0, '0', 0, '', '', ''),
(36, 'MP', '피파울', 50000, 104, 120, 300, 0, 0, 0, 95, 0, '3', 0, '', '', '유닛의 공격력을 15% 상승시킵니다.'),
(37, 'MP', '피코크', 50000, 106, 105, 280, 0, 0, 0, 105, -25, '0', 0, '', '', ''),
(38, 'MP', '래거드', 50000, 108, 180, 150, 0, 0, 0, 60, 0, '0', 0, '', '', '이동 감소 효과가 발생하였을 경우 해당 시간을 절반으로 줄어들게 합니다.'),
(39, 'BP', '코포럴', 1000, 1, 30, 150, 0, 400, 3, 0, 0, '0', 9, '', '탑형', ''),
(40, 'BP', '스쿼드', 1000, 1, 15, 80, 0, 180, 3, 0, 0, '0', 21, '', '팔형', ''),
(41, 'BP', '스쿼미쉬', 1000, 1, 10, 90, 0, 150, 0, 0, 0, '0', 12, '', '어깨형', ''),
(42, 'BP', '플래툰', 1000, 3, 20, 100, 0, 300, 7, 0, -20, '0', 21, '', '팔형', ''),
(43, 'BP', '플래툰N', 10000, 3, 20, 100, 0, 300, 7, 0, -30, '0', 21, '', '팔형', ''),
(44, 'BP', '뱅가드', 1000, 5, 20, 90, 0, 250, 0, 0, 0, '0', 16, '', '어깨형', ''),
(45, 'BP', '스쿼드론', 1000, 12, 25, 130, 0, 380, 10, 0, 0, '0', 26, '', '팔형', ''),
(46, 'BP', '블릿츠', 1000, 14, 15, 120, 0, 300, 0, 0, -15, '0', 17, '', '어깨형', ''),
(47, 'BP', '서전', 1000, 16, 35, 180, 0, 550, 3, 0, 0, '0', 12, '', '탑형', ''),
(48, 'BP', '스파덱', 1000, 20, 10, 100, 0, 150, 0, 5, -10, '0', 19, '', '탑형', '조립시 체력을 30% 상승 시킵니다.'),
(49, 'BP', '스파덱N', 10000, 20, 10, 100, 0, 300, 0, 5, -15, '0', 19, '', '탑형', ''),
(50, 'BP', '바탈리언', 5000, 23, 20, 180, 0, 400, 10, 0, 0, '0', 29, '', '팔형', ''),
(51, 'BP', '메인포스', 5000, 25, 25, 120, 0, 380, 0, 0, 25, '2', 16, '', '어깨형', ''),
(52, 'BP', '캡틴', 5000, 28, 35, 240, 0, 650, 5, 0, 0, '0', 12, '', '탑형', '5초마다 유닛의 최대 체력 2%를 자동 회복 합니다.'),
(53, 'BP', '레지먼트', 5000, 33, 30, 300, 0, 650, 15, 0, 0, '0', 24, '', '팔형', ''),
(54, 'BP', '센추리언', 5000, 35, 15, 150, 0, 380, 0, 0, -25, '0', 18, '', '어깨형', ''),
(55, 'BP', '센추리언N', 20000, 35, 15, 150, 0, 380, 0, 0, -30, '0', 18, '', '어깨형', ''),
(56, 'BP', '커널', 5000, 38, 45, 280, 0, 750, 5, 0, 0, '0', 15, '', '탑형', ''),
(57, 'BP', '쿼터덱', 5000, 40, 15, 120, 0, 220, 0, 10, 0, '0', 17, '', '탑형', '조립시 체력을 25% 상승 시킵니다.'),
(58, 'BP', '쿼터덱N', 20000, 40, 15, 120, 0, 350, 0, 15, 0, '0', 17, '', '탑형', ''),
(59, 'BP', '브리게이드', 10000, 43, 45, 400, 0, 1000, 7, 0, 0, '0', 21, '', '팔형', ''),
(60, 'BP', '브리게이드N', 30000, 43, 45, 400, 0, 1000, -30, 0, 0, '-3', 21, '', '팔형', '조립시 체력을 50% 상승 시킵니다.</br></br>방어 -30'),
(61, 'BP', '트리뷴', 10000, 45, 30, 160, 0, 450, 0, 0, 0, '0', 18, '', '어깨형', '5초마다 유닛의 최대 체력 2%를 자동 회복 합니다.'),
(62, 'BP', '코모도어', 10000, 48, 50, 360, 0, 1000, 10, 0, 0, '0', 15, '', '탑형', ''),
(63, 'BP', '코모도어N', 30000, 48, 50, 360, 0, 1000, -30, 0, 0, '-3', 15, '', '탑형', '조립시 체력을 50% 상승 시킵니다.</br></br>방어 -30'),
(64, 'BP', '스쿼칸', 10000, 50, 15, 120, 0, 250, 10, 5, -25, '0', 21, '', '팔형', ''),
(65, 'BP', '레지온', 10000, 53, 30, 220, 0, 450, 25, 0, 0, '0', 27, '', '팔형', ''),
(66, 'BP', '그라비스', 10000, 55, 35, 280, 0, 700, 10, 0, 0, '0', 18, '', '어깨형', ''),
(67, 'BP', '블릿칸', 10000, 55, 15, 150, 0, 350, 3, 5, -25, '0', 18, '', '어깨형', ''),
(68, 'BP', '그라비스N', 30000, 55, 35, 280, 0, 600, 10, 0, 0, '0', 18, '', '어깨형', '5초마다 유닛의 최대 체력 3%를 자동 회복 합니다.'),
(69, 'BP', '제너럴', 10000, 58, 70, 450, 0, 1300, 5, 0, 0, '0', 15, '', '탑형', ''),
(70, 'BP', '플러시덱', 10000, 60, 15, 150, 0, 370, 0, 5, 0, '0', 20, '', '탑형', ''),
(71, 'BP', '코포칸', 10000, 60, 15, 180, 0, 350, 10, 5, -25, '0', 15, '', '탑형', ''),
(72, 'BP', '캡티널', 20000, 64, 40, 300, 0, 700, 10, 0, 0, '0', 12, '', '탑형', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(73, 'BP', '마샬', 20000, 68, 60, 420, 0, 1150, 5, 0, 0, '0', 12, '', '탑형', ''),
(74, 'BP', '레지널', 20000, 72, 40, 370, 0, 700, 15, 0, 0, '0', 24, '', '팔형', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(75, 'BP', '트리뷰널', 20000, 78, 30, 220, 0, 500, 3, 0, 0, '0', 18, '', '어깨형', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(76, 'BP', '제니스', 30000, 83, 40, 400, 0, 600, 25, 0, 0, '0', 18, '', '어깨형', '유닛 체력이 30%이하로 떨어지면 유닛 방어력이 40 증가합니다.'),
(77, 'BP', '제니스N', 60000, 83, 40, 400, 0, 600, 25, 0, 0, '0', 18, '', '어깨형', '유닛 체력이 60%이하로 떨어지면 유닛 방어력이 40 증가합니다.'),
(78, 'BP', '킹핀', 30000, 87, 40, 480, 0, 700, 35, 0, 0, '0', 25, '', '팔형', '유닛 체력이 30%이하로 떨어지면 유닛 방어력이 40 증가합니다.'),
(79, 'BP', '킹핀N', 60000, 87, 40, 480, 0, 700, 30, 0, 0, '0', 25, '', '팔형', '유닛 체력이 60%이하로 떨어지면 유닛 방어력이 40 증가합니다.'),
(80, 'BP', '바이스로이', 40000, 93, 65, 450, 0, 800, 40, 0, 0, '0', 14, '', '탑형', ''),
(81, 'BP', '킹핀II', 40000, 95, 50, 500, 0, 400, 65, 0, 0, '0', 21, '', '팔형', ''),
(82, 'BP', '플랫피쉬', 50000, 100, 40, 450, 0, 450, 50, 0, 0, '0', 19, '', '어깨형', ''),
(83, 'BP', '플랫피쉬N', 100000, 100, 40, 450, 0, 350, 50, 0, 0, '0', 19, '', '어깨형', '조립시 유닛 공격력이 20% 상승합니다.'),
(84, 'BP', '센추러스', 50000, 101, 20, 120, 0, 350, 0, 0, 0, '2', 21, '', '어깨형', '유닛의 공격력을 10% 상승시킵니다.</br></br>5초마다 유닛의 체력이 2% 감소됩니다.'),
(85, 'BP', '버서커', 50000, 102, 30, 250, 0, 500, 0, 0, 0, '0', 24, '', '팔형', '유닛의 체력이 50% 미만으로 떨어졌을 경우 유닛의 공격력이 50% 상승합니다.'),
(86, 'BP', '쿼러시어', 50000, 102, 40, 300, 0, 550, 15, 5, 0, '0', 24, '', '팔형', '5초마다 유닛의 최대 체력 3%를 자동 회복 합니다.</br></br>유닛의 공격력 10% 상승 시킵니다.'),
(87, 'BP', '홉라이트', 50000, 103, 35, 400, 0, 600, 20, 0, 0, '0', 25, '', '팔형', '5초마다 유닛의 최대 체력 5%를 자동 회복 합니다.'),
(88, 'BP', '인펜트리', 50000, 104, 25, 190, 0, 450, 5, 0, 0, '0', 15, '', '어깨형', '5초마다 유닛의 최대 체력 3%를 자동 회복 합니다.</br></br>유닛의 체력을 5% 상승시킵니다.'),
(89, 'BP', '커맨더', 50000, 105, 70, 500, 0, 1500, 10, 0, 0, '0', 15, '', '탑형', ''),
(90, 'BP', '벤투스', 50000, 106, 25, 250, 0, 500, 10, 15, -10, '0', 12, '', '탑형', ''),
(91, 'AP', '데미시즈', 1000, 1, 40, 120, 35, 0, 0, 0, 150, '7-25', 0, '지상', '탑형', ''),
(92, 'AP', '배럴', 1000, 1, 10, 110, 18, 0, 5, 0, 150, '16', 0, '지&공', '팔형', ''),
(93, 'AP', '아모건', 1000, 1, 10, 50, 10, 0, 0, 0, 100, '10', 0, '지&공', '어깨형', ''),
(94, 'AP', '데미시즈N', 10000, 1, 35, 120, 35, 0, 0, 15, 150, '7-25', 0, '지상', '탑형', '적 유닛의 방어력 30을 무시합니다.'),
(95, 'AP', '머신건', 1000, 2, 15, 60, 12, 0, 0, 0, 100, '11', 0, '지&공', '팔형', ''),
(96, 'AP', '듀얼건', 1000, 4, 15, 70, 15, 0, 0, 0, 100, '23', 0, '지&공', '어깨형', ''),
(97, 'AP', '에너맥스', 1000, 7, 10, 100, 0, 0, 0, 10, 100, '7', 0, '지상/범위', '탑형', '조립시 체력 50% 상승</br></br>특수기술(키보드 C) 버튼을 눌러 선택된 범위안의 지상 유닛의 체력을 회복시켜 줍니다.'),
(98, 'AP', '시즈', 1000, 9, 40, 200, 70, 0, 0, 0, 250, '15-31', 0, '지상/범위', '탑형', ''),
(99, 'AP', '헤비배럴', 1000, 11, 25, 130, 30, 0, 5, 0, 100, '4-16', 0, '지상/범위', '팔형', ''),
(100, 'AP', '클러스터', 1000, 13, 25, 70, 15, 0, 0, 0, 125, '16', 0, '지&공', '어깨형', ''),
(101, 'AP', '클러스터N', 10000, 13, 25, 70, 15, 0, 0, 10, 100, '16', 0, '지&공', '어깨형', '스플레쉬 데미지 상승'),
(102, 'AP', '파워맥스', 1000, 15, 10, 100, 0, 0, 0, 10, 150, '7', 0, '지상/범위', '탑형', '조립시 체력 50% 상승</br></br>특수기술(키보드 C) 버튼을 눌러 선택된 범위안의 지상 유닛의 공격력을 올려줍니다.'),
(103, 'AP', '발칸', 1000, 17, 30, 120, 40, 0, 0, 0, 150, '10-25', 0, '지&공', '탑형', '적 유닛 공격 시 적 유닛의 방어력을 1.5배로 인식합니다.'),
(104, 'AP', '쇼크웨이브', 1000, 20, 20, 150, 15, 0, 0, 0, 100, '18', 0, '지&공', '탑형', '적 유닛의 최대 체력의 2%만큼 추가 데미지를 줍니다.</br></br>적 유닛의 방어력 20을 무시합니다.'),
(105, 'AP', '블레이즈', 5000, 21, 10, 100, 0, 0, 0, 0, 3000, '10', 0, '지상/범위', '어깨형', '특수기술(키보드 C) 버튼을 눌러 일정범위에 불 공격으로 적 유닛에게 데미지를 줍니다.'),
(106, 'AP', '핸드케넌', 5000, 22, 20, 120, 23, 0, 0, 10, 100, '14', 0, '지&공', '팔형', '적 유닛의 방어력 30을 무시합니다.'),
(107, 'AP', '핸드케넌N', 20000, 22, 20, 120, 23, 0, 10, 5, 100, '14', 0, '지&공', '팔형', '적 유닛의 방어력 50을 무시합니다.</br></br>방어 +10'),
(108, 'AP', '레이저', 5000, 24, 20, 170, 40, 0, 0, 15, 150, '23', 0, '지&공', '어깨형', ''),
(109, 'AP', '팔랑스', 5000, 27, 35, 170, 60, 0, 0, 0, 150, '13-28', 0, '지상', '탑형', '적 유닛 공격 시 적 유닛의 방어력을 2배로 인식합니다.'),
(110, 'AP', '스카이킬러', 5000, 30, 15, 100, 30, 0, 0, 0, 250, '25', 0, '공중', '어깨형', '적 유닛의 방어력 10를 무시합니다.</br>지상 유닛으로 조립하여도 공중 적 유닛에게는 모든 데미지를 줍니다.'),
(111, 'AP', '메가배럴', 5000, 32, 25, 100, 45, 0, 0, 0, 150, '4-16', 0, '지상/범위', '팔형', ''),
(112, 'AP', '메가배럴N', 20000, 32, 25, 100, 30, 0, 10, 0, 100, '4-16', 0, '지상/범위', '팔형', '방어 +10'),
(113, 'AP', '캐니스터', 5000, 34, 20, 90, 25, 0, 0, 0, 150, '19', 0, '지상/범위', '어깨형', ''),
(114, 'AP', '캐니스터N', 20000, 34, 20, 90, 25, 0, 0, 0, 150, '19', 0, '지상/범위', '어깨형', '조립시 체력 30% 상승</br></br>스플레쉬 데미지 상승'),
(115, 'AP', '헤비시즈', 5000, 37, 30, 230, 80, 0, 0, 0, 300, '16-34', 0, '지상/범위', '탑형', ''),
(116, 'AP', '사라만다', 5000, 40, 10, 120, 35, 0, 0, 5, 200, '6-25', 0, '지&공', '탑형', ''),
(117, 'AP', '스핏파이어', 10000, 42, 20, 180, 33, 0, 0, 15, 150, '14', 0, '지상', '팔형', '적 유닛의 최대 체력의 5%만큼 추가 데미지를 줍니다.</br></br>체력 리젠 -1%'),
(118, 'AP', '프롤릭스', 10000, 44, 15, 140, 25, 0, 0, 0, 150, '25', 0, '지&공', '어깨형', ''),
(119, 'AP', '바실리스크', 10000, 47, 45, 300, 130, 0, 0, 5, 350, '10-25', 0, '지&공', '탑형', '적 유닛의 방어력 10을 무시합니다.'),
(120, 'AP', '바실리스크N', 30000, 47, 40, 300, 130, 0, 0, 10, 350, '10-25', 0, '지&공', '탑형', '적 유닛의 방어력 30을 무시합니다.'),
(121, 'AP', '이지스', 10000, 49, 10, 100, 0, 0, 0, 10, 500, '7', 0, '지상/범위', '탑형', '조립시 체력을 50% 상승 시킵니다.</br></br>특수기술(키보드 C) 버튼을 눌러 방어막을 생성합니다.'),
(122, 'AP', '리코일건', 10000, 52, 25, 200, 65, 0, 0, 0, 200, '4-24', 2, '지&공', '팔형', ''),
(123, 'AP', '리코일건N', 30000, 52, 25, 200, 65, 0, 0, 0, 200, '4-24', 2, '지&공', '팔형', '특수기술(키보드 C) 버튼을 눌러 자신의 스피드를 30 상승 시킵니다.'),
(124, 'AP', '로켓티어', 10000, 54, 25, 110, 35, 0, 0, 0, 200, '14', 0, '지상/범위', '어깨형', ''),
(125, 'AP', '네메시즈', 10000, 57, 50, 400, 150, 0, 0, 0, 250, '18-42', 0, '지상/범위', '탑형', ''),
(126, 'AP', '호크아이', 10000, 59, 5, 50, 0, 0, 0, 0, 100, '127', 0, '지&공', '탑형', '특수기술(키보드 C) 버튼을 눌러 선택된 지역을 볼 수 있습니다.'),
(127, 'AP', '슈팅스타', 10000, 60, 10, 120, 20, 0, 0, 0, 200, '6-16', 0, '지상/범위', '탑형', ''),
(128, 'AP', '바주카', 20000, 62, 30, 200, 90, 0, 0, 0, 200, '3-24', 0, '지상', '팔형', ''),
(129, 'AP', '스콜피오', 20000, 67, 45, 300, 150, 0, 0, 0, 250, '21', 0, '지상', '탑형', ''),
(130, 'AP', '스콜피오N', 40000, 67, 45, 270, 150, 0, 0, 10, 250, '3-24', 0, '지상', '탑형', ''),
(131, 'AP', '서먼', 20000, 69, 10, 100, 0, 0, 0, 10, 0, '127', 0, '지상/범위', '탑형', '특수기술(키보드 C) 버튼을 눌러 선택된 범위의 유닛을 자신에게 소환 시킬 수 있습니다.'),
(132, 'AP', '선더볼트', 20000, 72, 40, 280, 45, 0, 0, 10, 200, '10', 0, '지상/범위', '팔형', '(AR전용)공격 받은 적 유닛은 순간적으로 전기쇼크를 입어 동작이 멈추게 됩니다.'),
(133, 'AP', '오닉스', 20000, 74, 25, 250, 80, 0, 0, 5, 125, '19', 0, '지상', '어깨형', ''),
(134, 'AP', '해머쇼크', 30000, 82, 40, 350, 80, 0, 0, 10, 50, '9', 0, '지상', '팔형', '특수기술(키보드 C) 버튼을 눌러 자신의 방어력을 상승 시킵니다.'),
(135, 'AP', '해머쇼크N', 60000, 82, 40, 350, 80, 0, 15, 10, 50, '9', 0, '지상', '팔형', '특수기술(키보드 C) 버튼을 눌러 자신의 공격력을 50% 상승 시킵니다.</br></br>방어 +15'),
(136, 'AP', '아누아이', 30000, 87, 30, 300, 70, 0, 0, 0, 200, '25', 0, '공중', '어깨형', '방어력 40 무시</br></br>스타쉽, 포퍼스에게는 30% 추가데미지</br>지상 유닛으로 조립하여도 공중 유닛에게는 모든 데미지를 줌.'),
(137, 'AP', '멀티샷건', 40000, 91, 50, 350, 65, 0, 0, 0, 150, '21', 0, '지상', '팔형', '유닛의 체력을 10% 상승시킵니다.</br></br>(AR전용)공격시 자신의 공격력을 1/3 감소 시킵니다.'),
(138, 'AP', '스틱스', 40000, 93, 45, 400, 220, 0, 0, 5, 500, '6-24', 0, '지&공', '어깨형', '적 유닛 공격 시 적 유닛의 방어력을 2배로 인식합니다.'),
(139, 'AP', '스틱스N', 80000, 93, 45, 400, 220, 0, 0, 0, 500, '6-24', 0, '지&공', '어깨형', '적 유닛 공격 시 적 유닛의 방어력을 1.5배로 인식합니다.'),
(140, 'AP', '버닝소울', 40000, 97, 60, 450, 70, 0, 0, 0, 300, '15-35', 0, '지상/범위', '탑형', '적 유닛의 방어력 10을 무시합니다.'),
(141, 'AP', '데빌클로', 50000, 100, 40, 350, 50, 0, 0, 5, 100, '18', 0, '지&공', '팔형', '적 유닛의 방어력 100을 무시합니다.'),
(142, 'AP', '프리징소울', 50000, 100, 60, 400, 40, 0, 0, 10, 450, '15-34', 0, '지상/범위', '탑형', '공격 받은 적 유닛은 3초동안 이동 불가 상태가 됩니다.'),
(143, 'AP', '스나이퍼', 50000, 100, 30, 400, 100, 0, 0, -5, 350, '24-36', -3, '지&공', '팔형', '적 유닛의 방어력 30%를 무시합니다.'),
(144, 'AP', '에리니스', 50000, 101, 20, 200, 35, 0, 0, 0, 150, '25', 0, '지&공', '어깨형', '적에게 주는 데미지 30%를 자신의 체력으로 회복 시킵니다.</br></br>5초마다 유닛의 체력이 최대 체력의 2%만큼 감소합니다.'),
(145, 'AP', '인센디어리', 50000, 103, 35, 300, 40, 0, 0, 0, 300, '5-23', 0, '지상/범위', '팔형', '일정범위(반경 5이내)에 초당 적 유닛의 최대 체력의 5%만큼 추가 데미지를 3초동안 줍니다.'),
(146, 'AP', '베베세', 50000, 103, 30, 280, 30, 0, 0, 0, 150, '24', 0, '공중/범위', '팔형', '특수기술(키보드 C) 버튼을 눌러 자신의 공격력을 30% 상승 시킵니다.</br>공중 전용 공격부품.</br>체력 4%데미지.'),
(147, 'AP', '베베세N', 100000, 103, 30, 280, 20, 0, 10, 0, 150, '24', 0, '공중', '팔형', '특수기술(키보드 C) 버튼을 눌러 자신의 공격력을 30% 상승</br>방어 +10</br>공중 전용 공격부품.</br>스플 범위내 100% 데미지.'),
(148, 'AP', '레디에이트', 50000, 104, 40, 300, 50, 0, 0, 0, 150, '24', 0, '지&공/범위', '팔형', '적 유닛의 방어력 50을 무시합니다.</br>공격지점까지 일직선 공격</br>유닛 조립시</br>지상 -> 지상전용</br>공중 -> 공중전용'),
(149, 'AP', '립타리온', 50000, 105, 35, 250, 90, 0, 0, 0, 200, '13-28', 0, '지상', '탑형', '공격 받은 유닛의 연사를 2초간 50 늘려 줍니다.'),
(150, 'AP', '아포칼립스', 50000, 107, 65, 550, 500, 0, 0, 0, 1500, '30-40', 0, '지상/범위', '탑형', '타워링악세사리와 조립 불가능</br>기지 데미지 불가</br>몸통 부품 무게 30이상만 조립가능'),
(151, 'AcP', '체력100', 100, 6, 5, 0, 0, 100, 0, 0, 0, '', 0, '', '', ''),
(152, 'AcP', '파워5', 100, 7, 5, 0, 5, 0, 0, 0, 0, '', 0, '', '', ''),
(153, 'AcP', '와트30', 300, 10, 5, -30, 0, 0, 0, 0, 0, '', 0, '', '', ''),
(154, 'AcP', '와트50', 700, 15, 10, -50, 0, 0, 0, 0, 0, '', 0, '', '', ''),
(155, 'AcP', '파워10', 500, 18, 5, 0, 10, 0, 0, 0, 0, '', 0, '', '', ''),
(156, 'AcP', '체력150', 500, 18, 10, 0, 0, 150, 0, 0, 0, '', 0, '', '', ''),
(157, 'AcP', '체력듀얼', 3000, 18, 10, 0, 5, 150, 0, 0, 0, '', 0, '', '', ''),
(158, 'AcP', '파워듀얼', 3000, 18, 10, 0, 15, 50, 0, 0, 0, '', 0, '', '', ''),
(159, 'AcP', '듀얼', 3000, 18, 10, 0, 10, 100, 0, 0, 0, '', 0, '', '', ''),
(160, 'AcP', '체력180', 1000, 30, 15, 0, 0, 180, 0, 0, 0, '', 0, '', '', ''),
(161, 'AcP', '와트80', 2000, 30, 15, -80, 0, 0, 0, 0, 0, '', 0, '', '', ''),
(162, 'AcP', '파워15', 1000, 30, 10, 0, 15, 0, 0, 0, 0, '', 0, '', '', ''),
(163, 'AcP', '와트100', 10000, 35, 20, -100, 0, 0, 0, 0, 0, '', 0, '', '', ''),
(164, 'AcP', '체력210', 5000, 40, 20, 0, 0, 210, 0, 0, 0, '', 0, '', '', ''),
(165, 'AcP', '파워20', 5000, 40, 15, 0, 20, 0, 0, 0, 0, '', 0, '', '', ''),
(166, 'AcP', '타워링II', 30000, 55, 25, 20, 0, 0, 0, 0, 0, '', 0, '', '', '유닛을 타워로 만들어 줍니다.(키보드 T)</br>변신 후 체력 1.5배, 공격력 1.5배, 방어 +10, 사거리+1이 적용되며 변신시간은 6초'),
(167, 'AcP', '와트110', 12000, 55, 25, -110, 0, 0, 0, 0, 0, '', 0, '', '', ''),
(168, 'AcP', '와트120', 15000, 75, 35, -120, 0, 0, 0, 0, 0, '', 0, '', '', ''),
(169, 'AcP', '타워링', 30000, 80, 25, 20, 0, 0, 0, 0, 0, '', 0, '', '', '유닛을 타워로 만들어 줍니다.(키보드 T)</br>변신 후 체력 2배, 공격력 2배, 방어 +20, 사거리+1이 적용되며 변신시간은 10초'),
(170, 'AcP', '엔젤하트', 30000, 5, 5, -5, 5, 50, 5, 0, 0, '', 0, '', '', ''),
(171, 'AcP', '미니맥시', 50000, 10, 5, -30, 5, 50, 0, 0, 0, '', 0, '', '', ''),
(172, 'AcP', '투파', 5000000, 25, 25, 125, 25, 250, 0, 0, -25, '', 0, '', '', ''),
(173, 'AcP', 'H트라이', 1000000, 30, 15, -15, 5, 250, 0, 0, 0, '', 0, '', '', ''),
(174, 'AcP', 'P트라이', 1000000, 30, 15, -15, 20, 50, 0, 0, 0, '', 0, '', '', ''),
(175, 'AcP', 'W트라이', 1000000, 30, 15, -80, 5, 50, 0, 0, 0, '', 0, '', '', ''),
(176, 'AcP', '브론즈볼', 500000, 33, 5, -30, 6, 50, 0, 0, 0, '', 0, '', '', ''),
(177, 'AcP', '튜브', 500000, 33, 5, -30, 5, 60, 0, 0, 0, '', 0, '', '', ''),
(178, 'AcP', '쿼드디케', 30000, 40, 10, -10, 10, 0, 0, 10, 0, '', 0, '', '', ''),
(179, 'AcP', '지비킹', 1000000, 40, 20, -100, 10, 100, 0, -10, -15, '-2', 0, '', '', '(AR전용) 공격+10, 체력+100이 먼저 적용된 후 유닛의 최종 공격력 20%, 체력 10%를 하락시킵니다.'),
(180, 'AcP', 'P파나틱', 50000, 66, 10, -20, 20, -100, 0, 0, 0, '', 0, '', '', ''),
(181, 'AcP', 'H파나틱', 50000, 66, 10, -20, -5, 200, 0, 0, 0, '', 0, '', '', ''),
(182, 'AcP', 'R파나틱', 100000, 66, 10, -20, 0, 0, 0, -5, 0, '5', 5, '', '', ''),
(183, 'AcP', 'A파나틱', 100000, 66, 10, -20, 0, -75, 20, 0, 0, '', 0, '', '', ''),
(184, 'AcP', 'S파나틱', 50000, 66, 10, -20, 0, 0, 0, 20, 50, '', 0, '', '', ''),
(185, 'AcP', 'D파나틱', 100000, 66, 10, -20, 0, 0, 0, -10, -50, '', 0, '', '', ''),
(186, 'AcP', '제너러', 1000000, 66, 30, 50, 20, 200, 5, 5, 0, '', 0, '', '', ''),
(187, 'AcP', '실버볼', 1000000, 66, 15, -30, 15, 100, 0, 0, 0, '', 0, '', '', ''),
(188, 'AcP', '파라솔', 1000000, 66, 15, -30, 10, 150, 0, 0, 0, '', 0, '', '', ''),
(189, 'AcP', '듀얼맥시', 50000, 70, 10, 15, 15, 150, 0, 0, 0, '', 0, '', '', ''),
(190, 'AcP', '엠디킹', 1000000, 75, 30, 20, 20, 250, 15, 0, 0, '2', 0, '', '', '(AR전용)공격+20, 체력+250이 먼저 적용된 후 유닛의 최종 공격력 10%, 체력 20%를 하락시킵니다.'),
(191, 'AcP', '타워링S', 5000000, 80, 25, 20, 4, 40, 2, 0, 0, '', 0, '', '', '유닛을 타워로 만들어 줍니다.(키보드 T)</br>변신 후 체력 2배, 공격력 2배, 방어 +20, 사거리+1이 적용되며 변신시간은 10초'),
(192, 'AcP', '자이킹', 1000000, 85, 40, 100, 0, 0, 0, 0, 0, '', 0, '', '', '(AR전용) 유닛의 공격력 30%, 체력 30%를 올려줍니다.</br></br>5초마다 유닛의 최대 체력 2%를 자동 회복 합니다.'),
(193, 'AcP', '타워링III', 50000, 25, 20, 0, 0, 0, 0, 0, 0, '', 0, '', '', '유닛을 타워로 만들어 줍니다.(키보드 T)</br>부품 구입시 강화수치가 랜덤하게 붙습니다</br></br>변신 후 적용 수치는 타워링II와 같습니다.'),
(194, 'AcP', 'P쥬얼', 30000, 100, 30, 100, 0, 0, 0, 0, 0, '', 0, '', '', '특수 기술(키보드 C) 버튼을 누르면 자신의 유닛을 자폭시켜 주위의 적 유닛에게 데미지를 줍니다.'),
(195, 'AcP', 'A쥬얼', 30000, 100, 30, 50, 0, 0, 0, 0, 0, '', 0, '', '', '특수 기술(키보드 C) 버튼을 누르면 자신의 유닛을 자폭시켜 주위 아군의 체력과 방어를 올려 줍니다.'),
(196, 'AcP', 'C쥬얼', 30000, 100, 30, 150, 0, 0, 0, 0, 0, '', 0, '', '', '특수 기술(키보드 C) 버튼을 누르면 자신의 유닛 일정 범위안에 있는 유닛의 동작을 멈추게 합니다.'),
(197, 'AcP', '올인원', 10000000, 100, 45, 50, 25, 250, 5, 10, 0, '', 0, '', '', ''),
(198, 'AcP', '빅포암', 30000, 100, 25, 0, 30, 0, 0, 0, 0, '', 0, '', '', ''),
(199, 'AcP', '오픈스토', 30000, 100, 25, 0, 0, 350, 0, 0, 0, '', 0, '', '', ''),
(200, 'AcP', '마이저', 1000000, 100, 25, -120, -5, -50, 0, 10, 0, '', 0, '', '', ''),
(201, 'AcP', '골든볼', 30000000, 100, 45, 50, 20, 250, 15, 10, 0, '', 0, '', '', ''),
(202, 'AcP', '노바컵', 1000000, 100, 15, -40, 10, 90, 0, 0, 0, '', 0, '', '', ''),
(203, 'AcP', '데빌하트', 30000, 100, 5, -5, 5, 50, 0, 5, 0, '', 0, '', '', ''),
(204, 'AcP', '트리플맥시', 50000, 101, 15, -10, 10, 100, 0, 0, 0, '', 0, '', '', ''),
(205, 'AcP', '쿼드맥시', 50000, 101, 20, -30, 10, 150, 0, 0, 0, '', 3, '', '', ''),
(206, 'AcP', '미니투파', 100000, 101, 20, 25, 15, 150, 0, 0, -15, '', 0, '', '', ''),
(207, 'AcP', 'SR트라이', 1000000, 103, 15, -20, 0, 0, 0, 10, 0, '3', 0, '', '', ''),
(208, 'AcP', 'RA트라이', 1000000, 103, 15, -20, 0, 0, 12, 0, 0, '', 3, '', '', ''),
(209, 'AcP', 'DP트라이', 1000000, 103, 15, -20, 10, 0, 0, 0, -25, '', 0, '', '', ''),
(210, 'AcP', 'H-올인원', 10000000, 105, 35, -20, 10, 350, 5, 5, 0, '', 0, '', '', ''),
(211, 'AcP', 'P-올인원', 10000000, 105, 35, -20, 25, 100, 5, 5, 0, '', 0, '', '', ''),
(212, 'AcP', 'W-올인원', 10000000, 105, 35, -80, 10, 100, 5, 5, 0, '', 0, '', '', ''),
(213, 'AcP', '스피드스타', 500000, 105, 40, 0, 0, 0, 5, 30, 0, '', 0, '', '', ''),
(214, 'AcP', 'P-스타', 500000, 105, 40, 0, 50, 0, 0, 0, 0, '-6', 0, '', '', ''),
(215, 'AcP', 'H-스타', 500000, 105, 40, 0, 0, 500, 0, 0, 0, '', 0, '', '', ''),
(216, 'AcP', 'S-올인원', 15000000, 107, 35, -20, 15, 100, 0, 20, 0, '', 0, '', '', ''),
(217, 'AcP', 'A-올인원', 15000000, 107, 35, -20, 15, 100, 20, 0, 0, '', 0, '', '', ''),
(218, 'AcP', 'D-올인원', 15000000, 107, 35, -20, 15, 100, 0, 0, -30, '', 0, '', '', ''),
(219, 'AcP', '초신성', 99999999, 111, 50, 125, 30, 300, 10, 10, -15, '', 3, '', '', ''),
(220, 'AcP', '블랙홀', 99999999, 111, 65, 250, 90, 850, 25, 30, -50, '5', 5, '', '', '');

-- --------------------------------------------------------

--
-- 테이블 구조 `novalog`
--

CREATE TABLE `novalog` (
  `no` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `act` char(20) NOT NULL,
  `act_detail` char(80) NOT NULL,
  `IP` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `novaitem`
--
ALTER TABLE `novaitem`
  ADD PRIMARY KEY (`no`);

--
-- 테이블의 인덱스 `novalog`
--
ALTER TABLE `novalog`
  ADD PRIMARY KEY (`no`),
  ADD UNIQUE KEY `no` (`no`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `novalog`
--
ALTER TABLE `novalog`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
