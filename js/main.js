$(function () {
    // kind of class for slider
    function Slider(content, slidingTime) {
        // declarations
        this.sliderBlock = content;
        this.slidingTime = slidingTime;
        this.sliderI = 0;
        this.slideCount = $(this.sliderBlock+' .slides .slide').length;

        this.plusI = function () {
            if (this.sliderI === this.slideCount - 1){
                this.sliderI = 0;
            }else {
                this.sliderI += 1;
            }
        };
        this.minusI = function () {
            if (this.sliderI === 0){
                this.sliderI = this.slideCount - 1;
            } else {
                this.sliderI -= 1;
            }
        };
        this.getI = function (i) {
            return $(this.sliderBlock+' .slides .slide:eq('+i+')');
        };
        this.setItoLeft = function (i, time) {
            this.getI(i).animate({
                'left':'-100%'
            },time);
        };
        this.setItoRight = function (i, time) {
            this.getI(i).animate({
                'left':'100%'
            },time);
        };
        this.setItoCenter = function (i, time) {
            this.getI(i).animate({
                'left':'0'
            },time);
        };
        this.setActiveITab = function (i) {
            if($(this.sliderBlock).parent().parent().find('.tabs div').length === 0) {
                return false;
            }
            $(this.sliderBlock).parent().parent().find('.tabs div').removeClass('active')
            $(this.sliderBlock).parent().parent().find('.tabs div:eq('+i+')').addClass('active')
        }
        // preparing slider
        for(var i = 0;i < this.slideCount;i++) {
            this.setItoRight(i,0);
        }
        this.setItoCenter(0,0);
        // arrow click handler
        $(this.sliderBlock+' .arrow').click({ obj: this }, function (e) {
            var obj = e.data.obj;
            if ($(this).hasClass('left')){
                obj.setItoLeft(obj.sliderI, obj.slidingTime);
                obj.setItoRight(obj.sliderI, 0);
                obj.minusI();
                obj.setItoCenter(obj.sliderI, obj.slidingTime);
            }else if($(this).hasClass('right')){
                obj.setItoRight(obj.sliderI, obj.slidingTime);
                obj.plusI();
                obj.setItoLeft(obj.sliderI, 0);
                obj.setItoCenter(obj.sliderI, obj.slidingTime);
            }
            obj.setActiveITab(obj.sliderI);
        });
    }
    // activate sliders
    var slidingTime = 300;
    var sliderOpora1 = new Slider('#oporaSlider .slider-content', slidingTime);
    var sliderScheme = new Slider('#schemeSlider .slider-content', slidingTime);
    var sliderProject1 = new Slider('#ourProjects .slider-content', slidingTime);

});