$(function () {

    // kind of class for slider
    function Slider(content, slidingTime) {
        this.sliderBlock = content;
        this.slidingTime = slidingTime;
        this.sliderI = 0;
        this.slideCount = $(this.sliderBlock+' .slides .slide').length;
        alert()
        var plusI = function () {

        }
        var minusI = function () {

        }

    }
    var slidingTime = 300
    var sliderOpora = new Slider('#oporaSlider .slider-content', slidingTime);
    // var sliderScheme = new Slider('#schemeSlider .slider-content', slidingTime);
    // var sliderProject = new Slider('#ourProjects .slider-content', slidingTime);
})