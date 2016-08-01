'use strict';

module.exports = function strrev(string) {
  //       discuss at: http://locutus.io/php/strrev/
  //      original by: Kevin van Zonneveld (http://kvz.io)
  //      bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  //        example 1: strrev('Kevin van Zonneveld')
  //        returns 1: 'dlevennoZ nav niveK'
  //        example 2: strrev('a\u0301haB')
  //        returns 2: 'Baha\u0301' // combining
  //        example 3: strrev('A\uD87E\uDC04Z')
  //        returns 3: 'Z\uD87E\uDC04A' // surrogates
  //             test: 'skip-3'

  string = string + '';

  // Performance will be enhanced with the next two lines of code commented
  // out if you don't care about combining characters
  // Keep Unicode combining characters together with the character preceding
  // them and which they are modifying (as in PHP 6)
  // See http://unicode.org/reports/tr44/#Property_Table (Me+Mn)
  // We also add the low surrogate range at the beginning here so it will be
  // maintained with its preceding high surrogate

  var chars = ['�-�', '̀-ͯ', '҃-҉', '֑-ֽ', 'ֿ', 'ׁ', 'ׂ', 'ׄ', 'ׅ', 'ׇ', 'ؐ-ؚ', 'ً-ٞ', 'ٰ', 'ۖ-ۜ', '۞-ۤ', 'ۧۨ', '۪-ۭ', 'ܑ', 'ܰ-݊', 'ަ-ް', '߫-߳', 'ँ-ः', '़', 'ा-्', '॑-॔', 'ॢ', 'ॣ', 'ঁ-ঃ', '়', 'া-ৄ', 'ে', 'ৈ', 'ো-্', 'ৗ', 'ৢ', 'ৣ', 'ਁ-ਃ', '਼', 'ਾ-ੂ', 'ੇ', 'ੈ', 'ੋ-੍', 'ੑ', 'ੰ', 'ੱ', 'ੵ', 'ઁ-ઃ', '઼', 'ા-ૅ', 'ે-ૉ', 'ો-્', 'ૢ', 'ૣ', 'ଁ-ଃ', '଼', 'ା-ୄ', 'େ', 'ୈ', 'ୋ-୍', 'ୖ', 'ୗ', 'ୢ', 'ୣ', 'ஂ', 'ா-ூ', 'ெ-ை', 'ொ-்', 'ௗ', 'ఁ-ః', 'ా-ౄ', 'ె-ై', 'ొ-్', 'ౕ', 'ౖ', 'ౢ', 'ౣ', 'ಂ', 'ಃ', '಼', 'ಾ-ೄ', 'ೆ-ೈ', 'ೊ-್', 'ೕ', 'ೖ', 'ೢ', 'ೣ', 'ം', 'ഃ', 'ാ-ൄ', 'െ-ൈ', 'ൊ-്', 'ൗ', 'ൢ', 'ൣ', 'ං', 'ඃ', '්', 'ා-ු', 'ූ', 'ෘ-ෟ', 'ෲ', 'ෳ', 'ั', 'ิ-ฺ', '็-๎', 'ັ', 'ິ-ູ', 'ົ', 'ຼ', '່-ໍ', '༘', '༙', '༵', '༷', '༹', '༾', '༿', 'ཱ-྄', '྆', '྇', 'ྐ-ྗ', 'ྙ-ྼ', '࿆', 'ါ-ှ', 'ၖ-ၙ', 'ၞ-ၠ', 'ၢ-ၤ', 'ၧ-ၭ', 'ၱ-ၴ', 'ႂ-ႍ', 'ႏ', '፟', 'ᜒ-᜔', 'ᜲ-᜴', 'ᝒ', 'ᝓ', 'ᝲ', 'ᝳ', 'ា-៓', '៝', '᠋-᠍', 'ᢩ', 'ᤠ-ᤫ', 'ᤰ-᤻', 'ᦰ-ᧀ', 'ᧈ', 'ᧉ', 'ᨗ-ᨛ', 'ᬀ-ᬄ', '᬴-᭄', '᭫-᭳', 'ᮀ-ᮂ', 'ᮡ-᮪', 'ᰤ-᰷', '᷀-ᷦ', '᷾', '᷿', '⃐-⃰', 'ⷠ-ⷿ', '〪-〯', '゙', '゚', '꙯-꙲', '꙼', '꙽', 'ꠂ', '꠆', 'ꠋ', 'ꠣ-ꠧ', 'ꢀ', 'ꢁ', 'ꢴ-꣄', 'ꤦ-꤭', 'ꥇ-꥓', 'ꨩ-ꨶ', 'ꩃ', 'ꩌ', 'ꩍ', 'ﬞ', '︀-️', '︠-︦'];

  var graphemeExtend = new RegExp('(.)([' + chars.join('') + ']+)', 'g');

  // Temporarily reverse
  string = string.replace(graphemeExtend, '$2$1');
  return string.split('').reverse().join('');
};
//# sourceMappingURL=strrev.js.map