# PHP Template
본 템플릿은 소프트스퀘어드 서버 교육용 템플릿 입니다. (2021.07 ver.)


## ✨Common
### REST API
REST API의 기본 구성 원리를 반드시 구글링하여 익힌 뒤에 Route를 구성하자.

### Folder Structure
- `src`: 메인 로직 
  `src`에는 도메인 별로 패키지를 구성하도록 했다. **도메인**이란 회원(User), 게시글(Post), 댓글(Comment), 주문(Order) 등 소프트웨어에 대한 요구사항 혹은 문제 영역이라고 생각하면 된다. 각자 설계할 APP을 분석하고 필요한 도메인을 도출하여 `src` 폴더를 구성하자.
- `config` 및 `util` 폴더: 메인 로직은 아니지만 `src` 에서 필요한 부차적인 파일들을 모아놓은 폴더
- 도메인 폴더 구조
> Route - Controller - Provider/Service - DAO

- Route: Request에서 보낸 라우팅 처리
- Controller: Request를 처리하고 Response 해주는 곳. (Provider/Service에 넘겨주고 다시 받아온 결과값을 형식화), 형식적 Validation
- Provider/Service: 비즈니스 로직 처리, 의미적 Validation
- DAO: Data Access Object의 줄임말. Query가 작성되어 있는 곳. 

- 메소드 네이밍룰
  이 템플릿에서는 사용되는 메소드 명명 규칙은 User 도메인을 참고하자. 항상 이 규칙을 따라야 하는 것은 아니지만, 네이밍은 통일성 있게 해주는 게 좋다.
  

### Comparison
3개 템플릿 모두 다음과 같이 Request에 대해 DB 단까지 거친 뒤, 다시 Controller로 돌아와 Response 해주는 구조를 갖는다. 구조를 먼저 이해하고 템플릿을 사용하자.
> `Request` -> Route -> Controller -> Service/Provider -> DAO -> DB

> DB -> DAO -> Service/Provider -> Controller -> Route -> `Response`

다음은 각 템플릿 별 차이점을 비교 기술해 놓은 것이다.
#### PHP (패키지매니저 = composer)
> Request(시작) / Response(끝) ⇄ Router (index.php) ⇄ Controller  ⇄ Service (CUD) / Provider (R) ⇄ PDO (DB)

#### Node.js (패키지매니저 = npm)
> Request(시작) / Response(끝)  ⇄ Router (*Route.js) ⇄ Controller (*Controller.js) ⇄ Service (CUD) / Provider (R) ⇄ DAO (DB)

#### Springboot java (패키지매니저 = Maven (= Spring 선호), Gradle (Springboot 선호))
> Request(시작) / Response(끝) ⇄ Controller(= Router + Controller) ⇄ Service (CUD) / Provider (R) ⇄ DAO (DB)

### Validation
서버 API 구성의 기본은 Validation을 잘 처리하는 것이다. 외부에서 어떤 값을 날리든 Validation을 잘 처리하여 서버가 터지는 일이 없도록 유의하자.
값, 형식, 길이 등의 형식적 Validation은 Controller에서,
DB에서 검증해야 하는 의미적 Validation은 Provider 혹은 Service에서 처리하면 된다.

## ✨Structure
앞에 (*)이 붙어있는 파일(or 폴더)은 추가적인 과정 이후에 생성됨.
```
├── config                          
│   ├── BaseResponseStatus.php      # 상태 관리 코드
│   ├── Database.php                # 데이터베이스 설정                     
│   ├── Secret.php                  # 서버 Key 값들             
├── src                             
│   ├── User                        # User 도메인 폴더
│   │   ├── UserController.php      # req, res 처리
│   │   ├── UserProvider.php        # R에 해당하는 서버 로직 처리
│   │   ├── UserService.php         # CUD에 해당하는 서버 로직 처리  
│   │   ├── UserPdo.php             # User 관련 데이터베이스
├── utils                           
│   ├── CommonFunction.php          # 공통적으로 필요한 함수들
│   ├── HashFunction.php            # 암호화 관련 함수들
│   ├── JWTFunction.php             # JWT 관련 함수들
├── .gitignore                      # git 에 포함되지 않아야 하는 폴더, 파일들을 작성 해놓는 곳
├── * vendor                        # 외부 라이브러리 폴더
├── * logs                    	    # 로그 폴더
│   ├── access-xxxx-xx-xx.log       # access log
│   ├── errors-xxxx-xx-xx.log       # error log
├── composer.json                   # 필요한 외부 라이브러리
├── * composer.lock              	 
├── index.php                       # Routing 처리, logger 생성, ...                    		
└── README.md
```
## Usage
- `composer install`을 통해 `composer.json`에 설정해둔 외부 라이브러리 파일을 받는다. `vendor` 폴더와 `composer.lock` 파일이 생성된다.
- Permission denied 문제가 있을 경우 폴더 권한을 조정하자.
- src 폴더에는 `도메인` 별로 폴더와 파일을 구성하자. ex) Board > BoardController.php ...
- 500 Server Internal Error가 났을 때는 Nginx 에러 로그를 찾아보자.

## API 만들기 예제
[DB 연결 없이 TEST]
1. index.php 0. 테스트 API에 해당하는 부분을 주석 해제 한다. 
2. userController.php의 test API 부분을 주석 해제한다.
3. GET 외부IP/app/test로 테스트가 잘 되는지 확인한다.

[DB 연결 이후 TEST]
1. config > Database.php에서 본인의 DB 정보를 입력한다.
2. DB에 TEST를 위한 간단한 테이블을 하나 만든다.   
3. index.php, UserController.php, UserProvider.php, UserDao.php를 구성하여 해당 테이블의 값들을 불러오는 로직을 만든다.

## ERROR
서버 Error 를 확인했다면, 다양한 방법으로 원인을 찾아나가야 한다.
- Nginx 로그 확인 (로그 경로는 구글링)
- echo, print_r 로 디버깅
- 그 외 방법들.
    
## License
- 본 템플릿의 소유권은 소프트스퀘어드에 있습니다. 본 자료에 대한 상업적 이용 및 무단 복제, 배포 및 변경을 원칙적으로 금지하며 이를 위반할 때에는 형사처벌을 받을 수 있습니다.
