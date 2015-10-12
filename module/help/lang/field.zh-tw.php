<?php
$help->file->labels = '附件名稱|可以自己設定檔案的標題，如果不設定，則取附件原來的檔案名作為標題。';

$help->bug->product       = '所屬產品|設定bug所屬的產品。';
$help->bug->module        = '所屬模組|設定Bug所屬的模組。提示：Bug系統的模組和產品視圖裡面的模組是分開維護的。';
$help->bug->project       = '所屬項目|設定Bug所屬的項目。';
$help->bug->story         = '相關需求|設定Bug和哪個需求相關。';
$help->bug->task          = '相關任務|設定Bug和哪個任務相關。';
$help->bug->title         = 'bug標題|Bug的標題，應用清晰明了的描述，是非常重要的信息。';
$help->bug->severity      = '嚴重程度|Bug的嚴重程度，但和優先順序不能等同，一般按照1-4，嚴重程度遞減，但團隊也可以自己設定。';
$help->bug->pri           = '優先順序|Bug的優先順序，用來決定Bug處理的優先順序別，一般應當由產品人員或項目經理指定。';
$help->bug->type          = 'bug類型|仔細設置Bug的類型，對後面的統計幫助可以很有好處。可以看出產品的缺陷主要集中在什麼地方。';
$help->bug->os            = '操作系統|產生Bug的操作系統。';
$help->bug->browser       = '瀏覽器|產生Bug的瀏覽器，一般B/S架構的產品都會面臨不同瀏覽器的兼容問題，應當仔細設置，方便排查原因。';
$help->bug->steps         = '重現步驟|Bug的重現步驟，也是bug最為重要的信息，一定要將完整的重現步驟寫清楚。如果有抓圖，一定提供抓圖。提示：編輯器裡面可以直接上傳圖片。';
$help->bug->status        = 'bug狀態|Bug當前所處的狀態，禪道里面Bug總共為Active, Resolved, Closed三個狀態。';
$help->bug->mailto        = '抄送給|當前bug所有的操作都會抄送給該列表，抄送給可以是多個人，輸入用戶名(非真實姓名)進行選擇。';
$help->bug->openedby      = '由誰創建|Bug的創建者。';
$help->bug->openedbuild   = '影響版本|Bug影響的版本，可以選擇多個。提示：如果版本為空，需要到相應的項目中創建Build。';
$help->bug->assignedto    = '指派給|當前bug應當由誰處理，如果不清楚，留空。團隊應當指定由誰來負責處理指派為空的Bug。';
$help->bug->resolvedby    = '解決者|Bug的解決者。';
$help->bug->resolution    = '解決方案|Bug的解決方案，開發人員應當認真選擇該欄位，對後面的統計也非常有幫助。';
$help->bug->resolvedbuild = '解決版本|Bug的解決版本。';
$help->bug->closedby      = '由誰關閉|bug是由誰來關閉的。';
$help->bug->closeddate    = '關閉日期|Bug的關閉日期。';
$help->bug->duplicatebug  = '重複bug|重複的Bug，當解決方案為重複的時，必須指定重複的Bug的ID';
$help->bug->linkbug       = '相關bug|相關的Bug，和重複的bug不同，可以填寫多個Bug的Id，中間使用英文逗號隔開';
$help->bug->case          = '相關用例|bug的相關用例';
$help->bug->keywords      = '關鍵詞|可以靈活運用這個欄位，方便進行查詢檢索。';

$help->build->product  = '產品|所屬的產品。';
$help->build->project  = '項目|所屬的項目';
$help->build->name     = '名稱編號|Build的編號，團隊應當建立自己的配置管理規範，比如zentaopms.1.5.beta1.20110315';
$help->build->date     = 'build日期|打包的日期。';
$help->build->builder  = '構建者|誰創建的包';
$help->build->scmpath  = '原始碼地址|如果有原始碼管理系統，比如svn，可以填寫完整的build的地址(tag的地址)';
$help->build->filepath = '存儲地址|或者是編譯好之後的軟件包的存儲地址。';
$help->build->desc     = '描述|描述這個build完成了哪些功能，解決了哪些bug等，對測試的建議等。';

$help->company->name     = '公司名稱';
$help->company->phone    = '聯繫電話';
$help->company->fax      = '傳真';
$help->company->address  = '通訊地址';
$help->company->zipcode  = '郵政編碼';
$help->company->website  = '公司網站|即公司的官網地址，要寫完整的http://，會出現在頁面最上方，作為一個快捷連結。';
$help->company->backyard = '公司內網|即公司的內網地址，也要寫完整的http://，會出現頁面的最上方，作為一個快捷連結。';
$help->company->pms      = 'pms網站|也就是禪道系統的域名，這個一般不需要修改，如果修改，不要填寫http，只填域名部分。';
$help->company->guest    = '匿名登錄|是否運行匿名登錄。如果允許的話，需要在組織視圖中，添加一個guest分組，併為該組分配相應的權限。';

$help->convert->dbhost     = '資料庫伺服器|來源系統所在的伺服器。';
$help->convert->dbport     = '伺服器連接埠|來源系統資料庫運行的連接埠號，一般是3306。';
$help->convert->dbuser     = '資料庫用戶名|訪問來源系統資料庫的帳號。';
$help->convert->dbpassword = '資料庫密碼|訪問來源系統資料庫的密碼。';
$help->convert->dbname     = '使用的庫|資料庫的名字。';
$help->convert->dbprefix   = '表首碼|表的首碼。';
$help->convert->installpath= '安裝的根目錄|來源系統所在的根目錄，一般用來拷貝附件。如果來源系統和禪道不在同一台機器，請先將其拷貝到一台機器。';

$help->dept->depts  = '下級部門|每次最多可以設置五個下級部門。';
$help->dept->orders = '部門排序|輸入數字，可以對部門進行排序，建議數字有一定的間隔，方便中間插入新的數據。';

$help->group->name = '分組名稱|如果設置公司允許匿名訪問，需要建立一個guest的分組，然後為其分配相應的權限。';
$help->group->desc = '分組描述';

$help->install->webroot     = 'pms所在的目錄|安裝的時候，程序會自動設置，一般無需修改。如果後面目錄有移動，需要修改config/my.php中的webRoot變數。';
$help->install->requesttype = 'url方式|即通過什麼方式來訪問pms。GET方式是最通用的，靜態url地址方式需要有url重寫的功能。如果你不確定，建議使用GET方式。';
$help->install->defaultlang = '預設語言|可以設定系統預設訪問的語言。';
$help->install->dbhost      = '資料庫伺服器|資料庫所在的伺服器，一般來講為localhost，或者試試127.0.0.1';
$help->install->dbport      = '伺服器連接埠|一般為3306。';
$help->install->dbuser      = '資料庫用戶名|一般預設安裝為root';
$help->install->dbpassword  = '資料庫密碼|一般預設安裝密碼為空的。';
$help->install->dbname      = 'pms使用的庫|禪道使用的庫名。';
$help->install->dbprefix    = '建表使用的首碼|使用首碼，避免和其他的系統表名衝突。';
$help->install->cleardb     = '清空現有數據|如果庫裡面已經有過禪道的表，可以選擇該選項，重新安裝。';
$help->install->company     = '公司名稱|公司的名稱';
$help->install->pms         = 'pms地址|pms的地址，一般安裝的時候系統會自動設好，不需要修改。';
$help->install->account     = '管理員帳號|管理員的帳號，該管理員為超級管理員，擁有所有的權限。';
$help->install->password    = '管理員密碼|管理員的密碼。請儘量複雜。';

$help->product->name   = '產品名稱';
$help->product->code   = '產品代號|作為團隊內部對某一個產品的簡短稱呼。';
$help->product->po     = '產品負責人|當前產品的負責人，負責維護需求，解釋需求，制定計劃等。';
$help->product->rm     = '發佈負責人|由誰來負責創建各種版本，對外發佈這些工作。';
$help->product->qm     = '測試負責人|該產品的測試負責人，負責協調測試資源，管理測試任務等工作。';
$help->product->status = '狀態|產品的狀態，目前暫時分為正常和已結束。所謂已結束，就是產品不再有任何的行為，無論是開發，維護，還是銷售。';
$help->product->desc   = '產品描述';

$help->productplan->product = '產品';
$help->productplan->title   = '名稱|計劃的名稱，一般不要過長，簡短好記，方便團隊內部傳遞信息。';
$help->productplan->desc    = '描述|可以對計划進行較詳細的描述。';
$help->productplan->begin   = '開始日期|計劃開始的日期。';
$help->productplan->end     = '結束日期|計劃結束的日期。';

$help->project->name       = '項目名稱';
$help->project->code       = '項目代號|項目的代碼，作為團隊內部對某一個項目的簡短稱呼。';
$help->project->begin      = '開始日期|項目一般應該有明確的起止時間。';
$help->project->end        = '結束日期|對於scrum而言，一般不宜超過30天。';
$help->project->team       = '團隊名稱|團隊內部可以自己選擇自己喜歡的名稱。';
$help->project->status     = '項目狀態|只有狀態為進行中的項目，其燃燒圖才會在首頁出現。';
$help->project->desc       = '項目描述|項目的描述。';
$help->project->goal       = '項目目標|項目所要取得的目標。';
$help->project->updateburn = '更新燃盡圖|<br />1. 通過手工點擊“更新燃盡圖”來進行更新。<br />2. 通過計劃任務來進行更新。
                              詳情請查看<a href="http://www.zentao.net/help-read-79063.html" target="_blank">《如何更新燃盡圖》</a>';

$help->release->product = '產品';
$help->release->build   = 'build|所對應的build。build是在項目視圖中，在某一個項目中創建。';
$help->release->name    = '發佈名稱|產品對外發佈的名稱。比如禪道1.0正式版本';
$help->release->date    = '發佈日期';
$help->release->desc    = '描述|可以描述本次發佈的修改記錄，功能改進，下載連結等信息。';

$help->story->product        = '所屬產品';
$help->story->module         = '所屬模組|屬於哪個模組。做好功能模組的劃分，對維護需求來講很重要。';
$help->story->plan           = '產品計劃|屬於哪個計劃，通過計劃，可以對產品進行宏觀的把握。';
$help->story->title          = '需求名稱|很重要的信息，應該用清晰明了的語言描述。';
$help->story->spec           = '需求描述|需求的描述，儘量按照禪道給出的模板來描述。';
$help->story->verify         = '驗收標準|需求驗收的標準';
$help->story->pri            = '優先順序|很重要的欄位，在關聯需求到項目的時候，需要按照優先順序進行排序。';
$help->story->estimate       = '預計工時|產品人員在建立需求時，應對該需求所需要花費的時間進行大致估計，或者是團隊成員一起達成一致。該欄位在確定項目所做的需求時，其參考作用。';
$help->story->status         = '當前狀態|需求當前的狀態，其中只有處于激活狀態的需求才可能關聯到項目，進行任務的分解。';
$help->story->stage          = '所處階段|當需求處在激活狀態之後，描述需求當前所處的階段。一般不需要人手工維護，禪道系統會自動判斷。';
$help->story->mailto         = '抄送給|跟這個需求相關的人員，可以通過email的形式抄送給他們。提示：請輸入用戶名進行選擇。';
$help->story->openedby       = '由誰創建|需求的創建者，一般來講，也是需求的負責人。';
$help->story->openeddate     = '創建日期';
$help->story->assignedto     = '指派給|需求當前需要處理的人，一般用來走評審流程。';
$help->story->assigneddate   = '指派日期';
$help->story->closedby       = '由誰關閉|需求由誰關閉。';
$help->story->closeddate     = '關閉日期';
$help->story->closedreason   = '關閉原因|當一個需求被關閉之後，需要給一個關閉的原因。';
$help->story->rejectedreason = '拒絶原因|如果需求評審沒有通過，需要給一個拒絶的原因。';
$help->story->reviewedby     = '由誰評審|需求是由誰來評審的。可能是多個人。比如團隊開會，共同討論某一個需求。';
$help->story->revieweddate   = '評審時間';
$help->story->comment        = '備註';
$help->story->linkstories    = '相關需求|相關的需求，可以是多個需求的id，用逗號隔開。';
$help->story->childstories   = '細分需求|該需求太大，細分成若干個小需求進行跟蹤。如果需求評審結果為已細分，需要給出細分之後的需求id。';
$help->story->duplicatestory = '重複需求';
$help->story->reviewresult   = '評審結果';
$help->story->keywords       = '關鍵詞|可以通過關鍵詞更好的組織維護需求。';
$help->story->neednotreview  = '不需要評審|如果團隊沒有需求評審流程，比如就只有一個產品人員，可以將這個選項勾上。';

$help->task->project    = '所屬項目';
$help->task->story      = '相關需求|任務所對應的需求。';
$help->task->name       = '任務名稱|很重要的信息，清晰明了的語言描述清楚。';
$help->task->type       = '任務類型|任務的類型，可以用來區分不同的任務。';
$help->task->pri        = '優先順序|很重要的欄位，用來對需求進行排序。';
$help->task->assignedto = '指派給|任務的負責人。';
$help->task->estimate   = '最初預計|對該任務最初的預計。單位為工時';
$help->task->left       = '預計剩餘|預計該任務完成還需要多少工時，非常重要的欄位，需要項目的每一位成員每天下班前來更新該欄位。項目的燃燒圖也是根據這個欄位計算出來的。';
$help->task->consumed   = '已經消耗|已經消耗的時間。需要注意的是，已經消耗 + 預計剩餘 和最初的預計不是必然相等的，很多時候往往是不等的。';
$help->task->deadline   = '截止日期|任務的截至日期，如果逾期，會有警告顯示。';
$help->task->status     = '任務狀態|任務當前的狀態。';
$help->task->desc       = '任務描述|任務的詳細描述。';

$help->testcase->product    = '所屬產品';
$help->testcase->module     = '所屬模組|提示：測試用例的模組也是和產品的單獨分開的，需要單獨維護。';
$help->testcase->story      = '相關需求|該用例對應到哪個需求，非常重要。';
$help->testcase->title      = '用例標題|非常重要的欄位，一定要描述清楚。尤其是在用例很多切相似的情況下。';
$help->testcase->pri        = '優先順序';
$help->testcase->type       = '用例類型|一般來講是功能測試，但如果測試充分，應當撰寫其他類型的測試用例。';
$help->testcase->status     = '用例狀態';
$help->testcase->steps      = '用例步驟|非常重要。不要將兩個用例混為一個用例。一個用例的步驟就是單純的一個用例，也就是說用例的細分越細越好。';
$help->testcase->openedby   = '由誰創建';
$help->testcase->openeddate = '創建日期';
$help->testcase->result     = '測試結果|用例執行的結果';
$help->testcase->real       = '實際情況|用例執行的實際輸出';
$help->testcase->keywords   = '關鍵詞';
$help->testcase->linkcase   = '相關用例';
$help->testcase->stage      = '適用階段|該用例適用在什麼階段。';

$help->testtask->product    = '所屬產品|測試的是哪個產品。';
$help->testtask->project    = '所屬項目|哪個項目中產生的測試任務';
$help->testtask->build      = 'build|需要測試哪個Build，非常重要。測試人員測試的都應該是固定的東西，不應該是時刻變化的系統。如果沒有build，需要到項目視圖加以創建。';
$help->testtask->name       = '任務名稱|測試任務的名稱。';
$help->testtask->begin      = '開始日期';
$help->testtask->end        = '結束日期';
$help->testtask->desc       = '任務描述';
$help->testtask->status     = '當前狀態';
$help->testtask->assignedto = '指派給|一個測試任務可能要執行很多個測試用例，可以將測試用例進行細分，某某跑幾個用例，另外一個人跑其他的用例。';
$help->testtask->linkversion= '關聯(版本)|用例的版本，一般來講應當執行最新的版本。';
$help->testtask->lastrun    = '最後執行';
$help->testtask->lastresult = '最終結果';

$help->todo->date        = '日期|執行的日期，可以選擇暫不指定，只是做一個記錄，後面再來安排。';
$help->todo->begin       = '開始時間|預計開始的時間';
$help->todo->end         = '結束時間|預計結束的時間';
$help->todo->type        = '類型|類型，目前分為自定義，bug和任務三種。後兩者會自動將你所負責的任務或者bug列出，然後選擇是否今天處理。';
$help->todo->pri         = '優先順序|很重要，對事情一定要分優先順序。';
$help->todo->name        = '名稱';
$help->todo->status      = '狀態|當前的狀態。';
$help->todo->desc        = '描述|代辦事宜的描述。';
$help->todo->private     = '私人事務|私人事務，別人不會看到具體的內容。';

$help->user->account   = '用戶名|用來登錄使用的，英文，數字，下劃線的組合，三位以上。';
$help->user->password  = '密碼|六位以上。';
$help->user->password2 = '請重複密碼|確認密碼。';
$help->user->realname  = '真實姓名';
$help->user->email     = '郵箱|用來聯繫用的郵箱，很重要。禪道里面的很多提醒都是通過郵箱來做的。';
$help->user->join      = '加入日期|也就是員工的入職日期。';
$help->user->visits    = '訪問次數';
$help->user->ip        = '最後ip';
$help->user->last      = '最後登錄時間';

$help->my->date        = '選擇日期|選擇要查看的todo的日期';
$help->user->date      = '選擇日期|選擇要查看的todo的日期';

$help->doc->product    = '所屬產品';
$help->doc->project    = '所屬項目';
$help->doc->library    = '所屬文檔庫';
$help->doc->module     = '文檔分類';
$help->doc->type       = '文檔類型';
$help->doc->title      = '文檔標題';
$help->doc->digest     = '文檔摘要';
$help->doc->url        = '相應的連結地址';
