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
        });
    }
    // activate sliders
    var slidingTime = 300;
    var sliderOpora1 = new Slider('#oporaSlider .slider-content:eq(0)', slidingTime);
    var sliderOpora2 = new Slider('#oporaSlider .slider-content:eq(1)', slidingTime);
    var sliderOpora3 = new Slider('#oporaSlider .slider-content:eq(2)', slidingTime);
    var sliderOpora4 = new Slider('#oporaSlider .slider-content:eq(3)', slidingTime);
    var sliderScheme = new Slider('#schemeSlider .slider-content', slidingTime);
    var sliderProject1 = new Slider('#ourProjects .slider-content:eq(0)', slidingTime);
    var sliderProject2 = new Slider('#ourProjects .slider-content:eq(1)', slidingTime);

    // tabs handler
    $('.tabs div').click(function () {
        $(this).parent().parent().find('.tabs div').removeClass('active');
        $(this).addClass('active');
        $(this).parent().parent().find('.slider-content').removeClass('active');
        $(this).parent().parent().find('.slider-content:eq('+$(this).index()+')').addClass('active');
    });

});