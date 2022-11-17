<?php
// 1000 : 성공
const SUCCESS = array('isSuccess'=>true, 'code'=>1000, 'message'=>"통신 성공");

// Common
const TOKEN_VERIFICATION_SUCCESS = array( 'isSuccess' => true, 'code'=> 1001, 'message' => "JWT 토큰 검증 성공." );

// 2000 : Request 오류

// Common
const TOKEN_EMPTY = array( 'isSuccess' => false, 'code'=> 2000, 'message' => "JWT 토큰을 입력해주세요." );
const TOKEN_VERIFICATION_FAILURE = array( 'isSuccess' => false, 'code'=> 3000, 'message' => "JWT 토큰 검증 실패." );
const TOKEN_VERIFICATION_USERID_FAILURE = array( 'isSuccess' => false, 'code'=> 3001, 'message' => "JWT 토큰과 USER ID 대조 살패." );

// [POST] /users
const POST_USERS_EMPTY_EMAIL = array('isSuccess'=>false, 'code'=>2001, 'message'=>"유저 이메일을 입력해주세요.");
const POST_USERS_INVALID_EMAIL = array('isSuccess'=>false, 'code'=>2002, 'message'=>"유저 이메일 형식을 확인해주세요.");
const POST_USERS_EMAIL_LENGTH = array('isSuccess'=>false, 'code'=>2003, 'message'=>"유저 이메일 길이는 최대 30자 입니다.");

// [GET] /users/{userId}
const GET_USERS_EMPTY_USER_ID = array('isSuccess'=>false, 'code'=>2004, 'message'=>"유저 아이디를 입력해주세요.");
const GET_USERS_EMPTY_USER_PW = array('isSuccess'=>false, 'code'=>2005, 'message'=>"유저 비밀번호를 입력해주세요.");

const USER_NICKNAME_EMPTY = array('isSuccess'=>false, 'code'=>2006, 'message'=>"유저 닉네임을 입력해주세요.");

// 3000 : Response 오류 (DB 접근)
const EMPTY_USERINFO = array('isSuccess'=>false, 'code'=>3002, 'message'=>"존재하지 않는 회원입니다.");

const POST_USER_REDUNDANT_EMAIL=array('isSuccess'=>false, 'code'=>3003, 'message'=>"중복된 이메일 입니다.");
const POST_USER_REDUNDANT_PHONENUM=array('isSuccess'=>false, 'code'=>3004, 'message'=>"중복된 핸드폰 번호 입니다.");

// 4000 : 실패 (Database, Server)
const SERVER_ERROR = array('isSuccess'=>false, 'code'=>4000, 'message'=>"서버 에러");