function getBreakpoint() {
    breakpoint = window.getComputedStyle(document.documentElement).getPropertyValue('--active-breakpoint');
    return breakpoint;
}

function reportBreakpoint() {
    getBreakpoint();
    console.log(breakpoint);
}

var breakpoint = getBreakpoint();  

window.onresize = reportBreakpoint;


function summaryOpen() {
    try {
      var sos = document.querySelectorAll('[data-summary-open]');
      for (var i of sos ) {
          i.addEventListener('click', function(e) {
              //console.log(e.target.dataset);
              summary = e.target.dataset.summaryOpen;
              if (!summary) {
                summary = e.target.parentNode.dataset.summaryOpen;
              }
              //console.log(e.target.dataset.summaryOpen);
              //document.querySelector(e.target.dataset.summaryOpen);
              //console.log(e.target.dataset.summaryOpen);
              if (summary) {
                document.querySelector(summary).open = true;
              }
              return true;
          });
      }
    }
    catch (error) {
      console.log('Old Browser?');
    }
}

document.addEventListener('DOMContentLoaded', function() {
  summaryOpen();
    
  /* var docWidth = document.documentElement.offsetWidth;
  [].forEach.call(
    document.querySelectorAll('*'),
    function(el) {
      if (el.offsetWidth > docWidth) {
        console.log(el);
      }
    }
  ); */
}, false);