import Template7 from 'template7';

window.Template7 = Template7;
import showdown from 'showdown';

Template7.registerHelper('convertToHtml', function (text) {
    var converter = new showdown.Converter();
  // First we need to check is the passed arr argument is function
  if (typeof text === 'function') text = text.call(this);

  /*
    Passed delimiter is in the options.hash object:
    console.log(options.hash) -> {delimiter: ', '}
  */

  // And return joined array
  return converter.makeHtml(text);
});