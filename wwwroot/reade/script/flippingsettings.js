function FlippingBook() {
    this.pages = [];
    this.zoomPages = [];
    this.printPages = [];
    this.contents = [];
    this.stageWidth = "100%";
    this.stageHeight = "100%";
    this.settings = {
        pagesSet: this.pages,
        zoomPagesSet: this.zoomPages,
        printPagesSet: this.printPages,
        scaleContent: true,//拉伸版面
        preserveProportions: false,//保留比例
        centerContent: true,
        hardcover: false,//精致书籍效果
        hardcoverThickness: 3,//模拟厚度，上方效果打开有效
        hardcoverEdgeColor: 0xFFFFFF,//模拟厚度颜色
        highlightHardcover: true,
        frameWidth: 0,//边框厚度
        frameColor: 0xFFFFFF,//边框颜色
        frameAlpha: 100,//边框透明度
        firstPageNumber: 1,//起始页码
        autoFlipSize: 50,
        navigationFlipOffset: 30,
        flipOnClick: true,//拖动翻页
        handOverCorner: true,//页角展开效果
        handOverPage: true,
        alwaysOpened: false,//总是展开两页
        staticShadowsType: "Symmetric", //中缝阴影 Asymmetric,不对称 Symmetric,对称 Default,默认
        staticShadowsDepth: 1,
        staticShadowsLightColor: 0xFFFFFF, // works for "Symmetric" shadows only 阴影颜色，仅Symmetric下有效
        staticShadowsDarkColor: 0x000000,
        dynamicShadowsDepth: 1,
        dynamicShadowsLightColor: 0xFFFFFF, // works for "dark" pages only
        dynamicShadowsDarkColor: 0x000000,
        moveSpeed: 2,//页角翻页速度
        closeSpeed: 3,//翻书速度
        gotoSpeed: 3,
        rigidPageSpeed: 5,
        flipSound: "sounds/01.mp3",
        hardcoverSound: "sounds/02.mp3",
        preloaderType: "Animated Book", //加载中特效 "Progress Bar", "Round", "Thin", "Dots", "Gradient Wheel", "Gear Wheel", "Line", "Animated Book", "None"
        pageBackgroundColor: 0x414654,//版面背景颜色
        loadOnDemand: true,
        allowPagesUnload: true,
        showUnderlyingPages: false,//允许缓冲页面
        playOnDemand: true,
        freezeOnFlip: false,
        darkPages: false,
        smoothPages: false,//图片光滑特效
        rigidPages: false,//硬纸板特效
        flipCornerStyle: "each page",//页角翻页风格 "first page only",仅第一页 "each page",每页 "manually",鼠标经过
        flipCornerPosition: "bottom-right",//页角翻页位置 "bottom-right","top-right","bottom-left","top-left"
        flipCornerAmount: 50,
        flipCornerAngle: 20,
        flipCornerRelease: true,
        flipCornerVibrate: true,
        flipCornerPlaySound: false,
        zoomEnabled: true,//允许缩放
        zoomOnClick: true,//双击放大
        zoomUIColor: 0x8f9ea6,
        zoomHint: "双击进行缩放",
        zoomHintEnabled: true,
        centerBook: true,//期刊居中
        useCustomCursors: true,
        dropShadowEnabled: true,
        dropShadowHideWhenFlipping: true,
        backgroundColor: 0xcccccc,//窗口背景颜色
        backgroundImagePlacement: "fit", //背景图片拉伸方式  "top left", "center", "fit"
        printEnabled: true,//开启打印
        printTitle: "打印页面",
        downloadTitle: "下载PDF版",
        downloadComplete: "下载完成",
        extXML: ""
    };
    this.containerId = "fbContainer";
    this.forwardButtonId = "fbForwardButton";
    this.backButtonId = "fbBackButton";
    this.zoomButtonId = "fbZoomButton";
    this.printButtonId = "fbPrintButton";
    this.downloadButtonId = "fbDownloadButton";
    this.currentPagesId = "fbCurrentPages";
    this.totalPagesId = "fbTotalPages";
    this.contentsMenuId = "fbContentsMenu";		
};