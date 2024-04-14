
  $(document).ready(function() {
    adjustFontSize();

    $(window).resize(function() {
      adjustFontSize();
    });
  });

  function adjustFontSize() {
    var containerWidth = $('.list-content').width();
    var textWidth = $('.game-name').width();

    var fontSize = parseFloat($('.game-name').css('font-size'));
    var newFontSize = fontSize;

    while (textWidth > containerWidth) {
      newFontSize -= 1;
      $('.game-name').css('font-size', newFontSize + 'px');
      textWidth = $('.game-name').width();
    }
  }
