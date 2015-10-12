<?php
$help->file->labels = '附件名称|可以自己设定文件的标题，如果不设定，则取附件原来的文件名作为标题。';

$help->bug->product       = '所属产品|设定bug所属的产品。';
$help->bug->module        = '所属模块|设定Bug所属的模块。提示：Bug系统的模块和产品视图里面的模块是分开维护的。';
$help->bug->project       = '所属项目|设定Bug所属的项目。';
$help->bug->story         = '相关需求|设定Bug和哪个需求相关。';
$help->bug->task          = '相关任务|设定Bug和哪个任务相关。';
$help->bug->title         = 'bug标题|Bug的标题，应用清晰明了的描述，是非常重要的信息。';
$help->bug->severity      = '严重程度|Bug的严重程度，但和优先级不能等同，一般按照1-4，严重程度递减，但团队也可以自己设定。';
$help->bug->pri           = '优先级|Bug的优先级，用来决定Bug处理的优先级别，一般应当由产品人员或项目经理指定。';
$help->bug->type          = 'bug类型|仔细设置Bug的类型，对后面的统计帮助可以很有好处。可以看出产品的缺陷主要集中在什么地方。';
$help->bug->os            = '操作系统|产生Bug的操作系统。';
$help->bug->browser       = '浏览器|产生Bug的浏览器，一般B/S架构的产品都会面临不同浏览器的兼容问题，应当仔细设置，方便排查原因。';
$help->bug->steps         = '重现步骤|Bug的重现步骤，也是bug最为重要的信息，一定要将完整的重现步骤写清楚。如果有抓图，一定提供抓图。提示：编辑器里面可以直接上传图片。';
$help->bug->status        = 'bug状态|Bug当前所处的状态，禅道里面Bug总共为Active, Resolved, Closed三个状态。';
$help->bug->mailto        = '抄送给|当前bug所有的操作都会抄送给该列表，抄送给可以是多个人，输入用户名(非真实姓名)进行选择。';
$help->bug->openedby      = '由谁创建|Bug的创建者。';
$help->bug->openedbuild   = '影响版本|Bug影响的版本，可以选择多个。提示：如果版本为空，需要到相应的项目中创建Build。';
$help->bug->assignedto    = '指派给|当前bug应当由谁处理，如果不清楚，留空。团队应当指定由谁来负责处理指派为空的Bug。';
$help->bug->resolvedby    = '解决者|Bug的解决者。';
$help->bug->resolution    = '解决方案|Bug的解决方案，开发人员应当认真选择该字段，对后面的统计也非常有帮助。';
$help->bug->resolvedbuild = '解决版本|Bug的解决版本。';
$help->bug->closedby      = '由谁关闭|bug是由谁来关闭的。';
$help->bug->closeddate    = '关闭日期|Bug的关闭日期。';
$help->bug->duplicatebug  = '重复bug|重复的Bug，当解决方案为重复的时，必须指定重复的Bug的ID';
$help->bug->linkbug       = '相关bug|相关的Bug，和重复的bug不同，可以填写多个Bug的Id，中间使用英文逗号隔开';
$help->bug->case          = '相关用例|bug的相关用例';
$help->bug->keywords      = '关键词|可以灵活运用这个字段，方便进行查询检索。';

$help->build->product  = '产品|所属的产品。';
$help->build->project  = '项目|所属的项目';
$help->build->name     = '名称编号|Build的编号，团队应当建立自己的配置管理规范，比如zentaopms.1.5.beta1.20110315';
$help->build->date     = 'build日期|打包的日期。';
$help->build->builder  = '构建者|谁创建的包';
$help->build->scmpath  = '源代码地址|如果有源代码管理系统，比如svn，可以填写完整的build的地址(tag的地址)';
$help->build->filepath = '存储地址|或者是编译好之后的软件包的存储地址。';
$help->build->desc     = '描述|描述这个build完成了哪些功能，解决了哪些bug等，对测试的建议等。';

$help->company->name     = '公司名称';
$help->company->phone    = '联系电话';
$help->company->fax      = '传真';
$help->company->address  = '通讯地址';
$help->company->zipcode  = '邮政编码';
$help->company->website  = '公司网站|即公司的官网地址，要写完整的http://，会出现在页面最上方，作为一个快捷链接。';
$help->company->backyard = '公司内网|即公司的内网地址，也要写完整的http://，会出现页面的最上方，作为一个快捷链接。';
$help->company->pms      = 'pms网站|也就是禅道系统的域名，这个一般不需要修改，如果修改，不要填写http，只填域名部分。';
$help->company->guest    = '匿名登录|是否运行匿名登录。如果允许的话，需要在组织视图中，添加一个guest分组，并为该组分配相应的权限。';

$help->convert->dbhost     = '数据库服务器|来源系统所在的服务器。';
$help->convert->dbport     = '服务器端口|来源系统数据库运行的端口号，一般是3306。';
$help->convert->dbuser     = '数据库用户名|访问来源系统数据库的帐号。';
$help->convert->dbpassword = '数据库密码|访问来源系统数据库的密码。';
$help->convert->dbname     = '使用的库|数据库的名字。';
$help->convert->dbprefix   = '表前缀|表的前缀。';
$help->convert->installpath= '安装的根目录|来源系统所在的根目录，一般用来拷贝附件。如果来源系统和禅道不在同一台机器，请先将其拷贝到一台机器。';

$help->dept->depts  = '下级部门|每次最多可以设置五个下级部门。';
$help->dept->orders = '部门排序|输入数字，可以对部门进行排序，建议数字有一定的间隔，方便中间插入新的数据。';

$help->group->name = '分组名称|如果设置公司允许匿名访问，需要建立一个guest的分组，然后为其分配相应的权限。';
$help->group->desc = '分组描述';

$help->install->webroot     = 'pms所在的目录|安装的时候，程序会自动设置，一般无需修改。如果后面目录有移动，需要修改config/my.php中的webRoot变量。';
$help->install->requesttype = 'url方式|即通过什么方式来访问pms。GET方式是最通用的，静态url地址方式需要有url重写的功能。如果你不确定，建议使用GET方式。';
$help->install->defaultlang = '默认语言|可以设定系统默认访问的语言。';
$help->install->dbhost      = '数据库服务器|数据库所在的服务器，一般来讲为localhost，或者试试127.0.0.1';
$help->install->dbport      = '服务器端口|一般为3306。';
$help->install->dbuser      = '数据库用户名|一般默认安装为root';
$help->install->dbpassword  = '数据库密码|一般默认安装密码为空的。';
$help->install->dbname      = 'pms使用的库|禅道使用的库名。';
$help->install->dbprefix    = '建表使用的前缀|使用前缀，避免和其他的系统表名冲突。';
$help->install->cleardb     = '清空现有数据|如果库里面已经有过禅道的表，可以选择该选项，重新安装。';
$help->install->company     = '公司名称|公司的名称';
$help->install->pms         = 'pms地址|pms的地址，一般安装的时候系统会自动设好，不需要修改。';
$help->install->account     = '管理员帐号|管理员的帐号，该管理员为超级管理员，拥有所有的权限。';
$help->install->password    = '管理员密码|管理员的密码。请尽量复杂。';

$help->product->name   = '产品名称';
$help->product->code   = '产品代号|作为团队内部对某一个产品的简短称呼。';
$help->product->po     = '产品负责人|当前产品的负责人，负责维护需求，解释需求，制定计划等。';
$help->product->rm     = '发布负责人|由谁来负责创建各种版本，对外发布这些工作。';
$help->product->qm     = '测试负责人|该产品的测试负责人，负责协调测试资源，管理测试任务等工作。';
$help->product->status = '状态|产品的状态，目前暂时分为正常和已结束。所谓已结束，就是产品不再有任何的行为，无论是开发，维护，还是销售。';
$help->product->desc   = '产品描述';

$help->productplan->product = '产品';
$help->productplan->title   = '名称|计划的名称，一般不要过长，简短好记，方便团队内部传递信息。';
$help->productplan->desc    = '描述|可以对计划进行较详细的描述。';
$help->productplan->begin   = '开始日期|计划开始的日期。';
$help->productplan->end     = '结束日期|计划结束的日期。';

$help->project->name       = '项目名称';
$help->project->code       = '项目代号|项目的代码，作为团队内部对某一个项目的简短称呼。';
$help->project->begin      = '开始日期|项目一般应该有明确的起止时间。';
$help->project->end        = '结束日期|对于scrum而言，一般不宜超过30天。';
$help->project->team       = '团队名称|团队内部可以自己选择自己喜欢的名称。';
$help->project->status     = '项目状态|只有状态为进行中的项目，其燃烧图才会在首页出现。';
$help->project->desc       = '项目描述|项目的描述。';
$help->project->goal       = '项目目标|项目所要取得的目标。';
$help->project->updateburn = '更新燃尽图|<br />1. 通过手工点击“更新燃尽图”来进行更新。<br />2. 通过计划任务来进行更新。
                              详情请查看<a href="http://www.zentao.net/help-read-79063.html" target="_blank">《如何更新燃尽图》</a>';

$help->release->product = '产品';
$help->release->build   = 'build|所对应的build。build是在项目视图中，在某一个项目中创建。';
$help->release->name    = '发布名称|产品对外发布的名称。比如禅道1.0正式版本';
$help->release->date    = '发布日期';
$help->release->desc    = '描述|可以描述本次发布的修改记录，功能改进，下载链接等信息。';

$help->story->product        = '所属产品';
$help->story->module         = '所属模块|属于哪个模块。做好功能模块的划分，对维护需求来讲很重要。';
$help->story->plan           = '产品计划|属于哪个计划，通过计划，可以对产品进行宏观的把握。';
$help->story->title          = '需求名称|很重要的信息，应该用清晰明了的语言描述。';
$help->story->spec           = '需求描述|需求的描述，尽量按照禅道给出的模板来描述。';
$help->story->verify         = '验收标准|需求验收的标准';
$help->story->pri            = '优先级|很重要的字段，在关联需求到项目的时候，需要按照优先级进行排序。';
$help->story->estimate       = '预计工时|产品人员在建立需求时，应对该需求所需要花费的时间进行大致估计，或者是团队成员一起达成一致。该字段在确定项目所做的需求时，其参考作用。';
$help->story->status         = '当前状态|需求当前的状态，其中只有处于激活状态的需求才可能关联到项目，进行任务的分解。';
$help->story->stage          = '所处阶段|当需求处在激活状态之后，描述需求当前所处的阶段。一般不需要人手工维护，禅道系统会自动判断。';
$help->story->mailto         = '抄送给|跟这个需求相关的人员，可以通过email的形式抄送给他们。提示：请输入用户名进行选择。';
$help->story->openedby       = '由谁创建|需求的创建者，一般来讲，也是需求的负责人。';
$help->story->openeddate     = '创建日期';
$help->story->assignedto     = '指派给|需求当前需要处理的人，一般用来走评审流程。';
$help->story->assigneddate   = '指派日期';
$help->story->closedby       = '由谁关闭|需求由谁关闭。';
$help->story->closeddate     = '关闭日期';
$help->story->closedreason   = '关闭原因|当一个需求被关闭之后，需要给一个关闭的原因。';
$help->story->rejectedreason = '拒绝原因|如果需求评审没有通过，需要给一个拒绝的原因。';
$help->story->reviewedby     = '由谁评审|需求是由谁来评审的。可能是多个人。比如团队开会，共同讨论某一个需求。';
$help->story->revieweddate   = '评审时间';
$help->story->comment        = '备注';
$help->story->linkstories    = '相关需求|相关的需求，可以是多个需求的id，用逗号隔开。';
$help->story->childstories   = '细分需求|该需求太大，细分成若干个小需求进行跟踪。如果需求评审结果为已细分，需要给出细分之后的需求id。';
$help->story->duplicatestory = '重复需求';
$help->story->reviewresult   = '评审结果';
$help->story->keywords       = '关键词|可以通过关键词更好的组织维护需求。';
$help->story->neednotreview  = '不需要评审|如果团队没有需求评审流程，比如就只有一个产品人员，可以将这个选项勾上。';

$help->task->project    = '所属项目';
$help->task->story      = '相关需求|任务所对应的需求。';
$help->task->name       = '任务名称|很重要的信息，清晰明了的语言描述清楚。';
$help->task->type       = '任务类型|任务的类型，可以用来区分不同的任务。';
$help->task->pri        = '优先级|很重要的字段，用来对需求进行排序。';
$help->task->assignedto = '指派给|任务的负责人。';
$help->task->estimate   = '最初预计|对该任务最初的预计。单位为工时';
$help->task->left       = '预计剩余|预计该任务完成还需要多少工时，非常重要的字段，需要项目的每一位成员每天下班前来更新该字段。项目的燃烧图也是根据这个字段计算出来的。';
$help->task->consumed   = '已经消耗|已经消耗的时间。需要注意的是，已经消耗 + 预计剩余 和最初的预计不是必然相等的，很多时候往往是不等的。';
$help->task->deadline   = '截止日期|任务的截至日期，如果逾期，会有警告显示。';
$help->task->status     = '任务状态|任务当前的状态。';
$help->task->desc       = '任务描述|任务的详细描述。';

$help->testcase->product    = '所属产品';
$help->testcase->module     = '所属模块|提示：测试用例的模块也是和产品的单独分开的，需要单独维护。';
$help->testcase->story      = '相关需求|该用例对应到哪个需求，非常重要。';
$help->testcase->title      = '用例标题|非常重要的字段，一定要描述清楚。尤其是在用例很多切相似的情况下。';
$help->testcase->pri        = '优先级';
$help->testcase->type       = '用例类型|一般来讲是功能测试，但如果测试充分，应当撰写其他类型的测试用例。';
$help->testcase->status     = '用例状态';
$help->testcase->steps      = '用例步骤|非常重要。不要将两个用例混为一个用例。一个用例的步骤就是单纯的一个用例，也就是说用例的细分越细越好。';
$help->testcase->openedby   = '由谁创建';
$help->testcase->openeddate = '创建日期';
$help->testcase->result     = '测试结果|用例执行的结果';
$help->testcase->real       = '实际情况|用例执行的实际输出';
$help->testcase->keywords   = '关键词';
$help->testcase->linkcase   = '相关用例';
$help->testcase->stage      = '适用阶段|该用例适用在什么阶段。';

$help->testtask->product    = '所属产品|测试的是哪个产品。';
$help->testtask->project    = '所属项目|哪个项目中产生的测试任务';
$help->testtask->build      = 'build|需要测试哪个Build，非常重要。测试人员测试的都应该是固定的东西，不应该是时刻变化的系统。如果没有build，需要到项目视图加以创建。';
$help->testtask->name       = '任务名称|测试任务的名称。';
$help->testtask->begin      = '开始日期';
$help->testtask->end        = '结束日期';
$help->testtask->desc       = '任务描述';
$help->testtask->status     = '当前状态';
$help->testtask->assignedto = '指派给|一个测试任务可能要执行很多个测试用例，可以将测试用例进行细分，某某跑几个用例，另外一个人跑其他的用例。';
$help->testtask->linkversion= '关联(版本)|用例的版本，一般来讲应当执行最新的版本。';
$help->testtask->lastrun    = '最后执行';
$help->testtask->lastresult = '最终结果';

$help->todo->date        = '日期|执行的日期，可以选择暂不指定，只是做一个记录，后面再来安排。';
$help->todo->begin       = '开始时间|预计开始的时间';
$help->todo->end         = '结束时间|预计结束的时间';
$help->todo->type        = '类型|类型，目前分为自定义，bug和任务三种。后两者会自动将你所负责的任务或者bug列出，然后选择是否今天处理。';
$help->todo->pri         = '优先级|很重要，对事情一定要分优先级。';
$help->todo->name        = '名称';
$help->todo->status      = '状态|当前的状态。';
$help->todo->desc        = '描述|代办事宜的描述。';
$help->todo->private     = '私人事务|私人事务，别人不会看到具体的内容。';

$help->user->account   = '用户名|用来登录使用的，英文，数字，下划线的组合，三位以上。';
$help->user->password  = '密码|六位以上。';
$help->user->password2 = '请重复密码|确认密码。';
$help->user->realname  = '真实姓名';
$help->user->email     = '邮箱|用来联系用的邮箱，很重要。禅道里面的很多提醒都是通过邮箱来做的。';
$help->user->join      = '加入日期|也就是员工的入职日期。';
$help->user->visits    = '访问次数';
$help->user->ip        = '最后ip';
$help->user->last      = '最后登录时间';

$help->my->date        = '选择日期|选择要查看的todo的日期';
$help->user->date      = '选择日期|选择要查看的todo的日期';

$help->doc->product    = '所属产品';
$help->doc->project    = '所属项目';
$help->doc->library    = '所属文档库';
$help->doc->module     = '文档分类';
$help->doc->type       = '文档类型';
$help->doc->title      = '文档标题';
$help->doc->digest     = '文档摘要';
$help->doc->url        = '相应的链接地址';
