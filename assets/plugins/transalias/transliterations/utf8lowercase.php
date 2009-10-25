<?php
/**
 * UTF-8 lowercase transliteration table
 */
return array (
// File/path punctuation (usually not wanted, but might be wanted in some cases) 
'/'=>'',
// Generally unwanted punctuation
'!'=>'', '('=>'', ')'=>'', '*'=>'', ','=>'', ':'=>'', ';'=>'', '…'=>'', '¡'=>'', '¿'=>'',
// various quotation marks
'‘'=>'', '’'=>'', '‚'=>'', '‛'=>'', '“'=>'', '”'=>'', '„'=>'', '‟'=>'', '«'=>'', '»'=>'', '‹'=>'', '›'=>'', 
// replace various spaces with a regular space (or nothing for zero-width spaces)
' '=>' ', // no-break space
' '=>' ', // en quad
' '=>' ', // em quad
' '=>' ', // en space
' '=>' ', // em space
' '=>' ', // three-per-em space
' '=>' ', // four-per-em space
' '=>' ', // six-per-em space
' '=>' ', // figure space
' '=>' ', // punctuation space
' '=>' ', // thin space
' '=>' ', // narrow no-break space
' '=>' ', // medium mathmatical space
'　'=>' ', // ideographic space
' '=>'', // hair width space
'​'=>'', // zero-width space
'﻿'=>'', // zero-width no-break space
'‍'=>'', // zero-width joiner
'‌'=>'', // zero-width non-joiner
'͏'=>'', // combining grapheme joiner
'⁠'=>'', // word joiner
// replace various hyphens with a standard hyphen
'­'=>'-', // some other hyphen
'‐'=>'-', // hyphen (2010)
'‑'=>'-', // non-breaking hyphen
'‒'=>'-', // figure dash
'–'=>'-', // en dash
'—'=>'-', // em dash
'―'=>'-', // horizontal bar
// greek
';'=>'', '΄'=>'',
// armenian punctuation
'ՙ'=>'', '՚'=>'', '՛'=>'', '՜'=>'', '՝'=>'', '՞'=>'', '՟'=>'', '։'=>'',
// hebrew punctuation
'׀'=>'', '׃'=>'', 
// arabic punctuation
'،'=>'', '؛'=>'', '؟'=>'', '۔'=>'',
// hindi punctuation
'।'=>'', '॥'=>'', 
// cjk punctuation
'，'=>'', '、'=>'', '。'=>'', '〃'=>'', '〈'=>'', '〉'=>'', '《'=>'', '》'=>'', 
'「'=>'', '」'=>'', '『'=>'', '』'=>'', '【'=>'', '】'=>'', '〔'=>'', '〕'=>'', 
'〖'=>'', '〗'=>'', '〘'=>'', '〙'=>'', '〚'=>'', '〛'=>'', 
'〝'=>'', '〞'=>'', '〟'=>'', '〿'=>'',
// basic latin and latin supplement
'A'=>'a', 'B'=>'b', 'C'=>'c', 'D'=>'d', 'E'=>'e', 'F'=>'f', 'G'=>'g', 'H'=>'h', 
'I'=>'i', 'J'=>'j', 'K'=>'k', 'L'=>'l', 'M'=>'m', 'N'=>'n', 'O'=>'o', 'P'=>'p', 
'Q'=>'q', 'R'=>'r', 'S'=>'s', 'T'=>'t', 'U'=>'u', 'V'=>'v', 'W'=>'w', 'X'=>'x', 
'Y'=>'y', 'Z'=>'z', 'À'=>'à', 'Á'=>'á', 'Â'=>'â', 'Ã'=>'ã', 'Ä'=>'ä', 'Å'=>'å', 
'Æ'=>'æ', 'Ç'=>'ç', 'È'=>'è', 'É'=>'é', 'Ê'=>'ê', 'Ë'=>'ë', 'Ì'=>'ì', 'Í'=>'í', 
'Î'=>'î', 'Ï'=>'ï', 'Ð'=>'ð', 'Ñ'=>'ñ', 'Ò'=>'ò', 'Ó'=>'ó', 'Ô'=>'ô', 'Õ'=>'õ', 
'Ö'=>'ö', 'Ø'=>'ø', 'Ù'=>'ù', 'Ú'=>'ú', 'Û'=>'û', 'Ü'=>'ü', 'Ý'=>'ý', 'Þ'=>'þ', 
'ß'=>'ß', 
// greek
'Α'=>'α', 'Β'=>'β', 'Γ'=>'γ', 'Δ'=>'δ', 'Ε'=>'ε', 'Ζ'=>'ζ', 'Η'=>'η', 'Θ'=>'θ', 
'Ι'=>'ι', 'Κ'=>'κ', 'Λ'=>'λ', 'Μ'=>'μ', 'Ν'=>'ν', 'Ξ'=>'ξ', 'Ο'=>'ο', 'Π'=>'π', 
'Ρ'=>'ρ', 'Σ'=>'ς', 'Τ'=>'τ', 'Υ'=>'υ', 'Φ'=>'φ', 'Χ'=>'χ', 'Ψ'=>'ψ', 'Ω'=>'ω', 
'Ϊ'=>'ϊ', 'Ϋ'=>'ϋ', 
// cyrillic
'Ё'=>'ё', 'Ђ'=>'ђ', 'Ѓ'=>'ѓ', 'Є'=>'є', 'Ѕ'=>'ѕ', 'І'=>'і', 'Ї'=>'ї', 'Ј'=>'ј', 
'Љ'=>'љ', 'Њ'=>'њ', 'Ћ'=>'ћ', 'Ќ'=>'ќ', 'Ў'=>'ў', 'Џ'=>'џ', 'А'=>'а', 'Б'=>'б', 
'В'=>'в', 'Г'=>'г', 'Д'=>'д', 'Е'=>'е', 'Ж'=>'ж', 'З'=>'з', 'И'=>'и', 'Й'=>'й', 
'К'=>'к', 'Л'=>'л', 'М'=>'м', 'Н'=>'н', 'О'=>'о', 'П'=>'п', 'Р'=>'р', 'С'=>'с', 
'Т'=>'т', 'У'=>'у', 'Ф'=>'ф', 'Х'=>'х', 'Ц'=>'ц', 'Ч'=>'ч', 'Ш'=>'ш', 'Щ'=>'щ',
'Ъ'=>'ъ', 'Ы'=>'ы', 'Ь'=>'ь', 'Э'=>'э', 'Ю'=>'ю', 'Я'=>'я', 
// latin extended
'Ā'=>'ā', 'Ă'=>'ă', 'Ą'=>'ą', 'Ć'=>'ć', 'Ĉ'=>'ĉ', 'Ċ'=>'ċ', 'Č'=>'č', 'Ď'=>'ď', 
'Đ'=>'đ', 'Ē'=>'ē', 'Ĕ'=>'ĕ', 'Ė'=>'ė', 'Ę'=>'ę', 'Ě'=>'ě', 'Ĝ'=>'ĝ', 'Ğ'=>'ğ', 
'Ġ'=>'ġ', 'Ģ'=>'ģ', 'Ĥ'=>'ĥ', 'Ħ'=>'ħ', 'Ĩ'=>'ĩ', 'Ī'=>'ī', 'Ĭ'=>'ĭ', 'Į'=>'į', 
'İ'=>'i̇', 'Ĳ'=>'ĳ', 'Ĵ'=>'ĵ', 'Ķ'=>'ķ', 'Ĺ'=>'ĺ', 'Ļ'=>'ļ', 'Ľ'=>'ľ', 'Ŀ'=>'ŀ', 
'Ł'=>'ł', 'Ń'=>'ń', 'Ņ'=>'ņ', 'Ň'=>'ň', 'Ŋ'=>'ŋ', 'Ō'=>'ō', 'Ŏ'=>'ŏ', 'Ő'=>'ő', 
'Œ'=>'œ', 'Ŕ'=>'ŕ', 'Ŗ'=>'ŗ', 'Ř'=>'ř', 'Ś'=>'ś', 'Ŝ'=>'ŝ', 'Ş'=>'ş', 'Š'=>'š', 
'Ţ'=>'ţ', 'Ť'=>'ť', 'Ŧ'=>'ŧ', 'Ũ'=>'ũ', 'Ū'=>'ū', 'Ŭ'=>'ŭ', 'Ů'=>'ů', 'Ű'=>'ű', 
'Ų'=>'ų', 'Ŵ'=>'ŵ', 'Ŷ'=>'ŷ', 'Ÿ'=>'ÿ', 'Ź'=>'ź', 'Ż'=>'ż', 'Ž'=>'ž', 'Ɓ'=>'ɓ', 
'Ƃ'=>'ƃ', 'Ƅ'=>'ƅ', 'Ɔ'=>'ɔ', 'Ƈ'=>'ƈ', 'Ɖ'=>'ɖ', 'Ɗ'=>'ɗ', 'Ƌ'=>'ƌ', 'Ǝ'=>'ǝ', 
'Ə'=>'ə', 'Ɛ'=>'ɛ', 'Ƒ'=>'ƒ', 'Ɠ'=>'ɠ', 'Ɣ'=>'ɣ', 'Ɩ'=>'ɩ', 'Ɨ'=>'ɨ', 'Ƙ'=>'ƙ', 
'Ɯ'=>'ɯ', 'Ɲ'=>'ɲ', 'Ɵ'=>'ɵ', 'Ơ'=>'ơ', 'Ƣ'=>'ƣ', 'Ƥ'=>'ƥ', 'Ʀ'=>'ʀ', 'Ƨ'=>'ƨ', 
'Ʃ'=>'ʃ', 'Ƭ'=>'ƭ', 'Ʈ'=>'ʈ', 'Ư'=>'ư', 'Ʊ'=>'ʊ', 'Ʋ'=>'ʋ', 'Ƴ'=>'ƴ', 'Ƶ'=>'ƶ', 
'Ʒ'=>'ʒ', 'Ƹ'=>'ƹ', 'ƻ'=>'ƻ', 'Ƽ'=>'ƽ', 'Ǆ'=>'ǆ', 'ǅ'=>'ǆ', 'Ǉ'=>'ǉ', 'ǈ'=>'ǉ', 
'Ǌ'=>'ǌ', 'ǋ'=>'ǌ', 'Ǎ'=>'ǎ', 'Ǐ'=>'ǐ', 'Ǒ'=>'ǒ', 'Ǔ'=>'ǔ', 'Ǖ'=>'ǖ', 'Ǘ'=>'ǘ', 
'Ǚ'=>'ǚ', 'Ǜ'=>'ǜ', 'Ǟ'=>'ǟ', 'Ǡ'=>'ǡ', 'Ǣ'=>'ǣ', 'Ǥ'=>'ǥ', 'Ǧ'=>'ǧ', 'Ǩ'=>'ǩ', 
'Ǫ'=>'ǫ', 'Ǭ'=>'ǭ', 'Ǯ'=>'ǯ', 'Ǳ'=>'ǳ', 'ǲ'=>'ǳ', 'Ǵ'=>'ǵ', 'Ǻ'=>'ǻ', 'Ǽ'=>'ǽ', 
'Ǿ'=>'ǿ', 'Ȁ'=>'ȁ', 'Ȃ'=>'ȃ', 'Ȅ'=>'ȅ', 'Ȇ'=>'ȇ', 'Ȉ'=>'ȉ', 'Ȋ'=>'ȋ', 'Ȍ'=>'ȍ', 
'Ȏ'=>'ȏ', 'Ȑ'=>'ȑ', 'Ȓ'=>'ȓ', 'Ȕ'=>'ȕ', 'Ȗ'=>'ȗ',
// japanese
    'ヴァ' => 'va',  'ヴィ' => 'vi',  'ヴェ' => 've',  'ヴォ' => 'vo',
    'キャ' => 'kya', 'キュ' => 'kyo', 'キョ' => 'kyo',
    'ギャ' => 'gya', 'ギュ' => 'gyu', 'ギョ' => 'gyo',
    'シャ' => 'sya', 'シュ' => 'syu', 'ショ' => 'syo',
    'ジャ' => 'ja',  'ジュ' => 'ju',  'ジェ' => 'je',  'ジョ' => 'jo',
    'チャ' => 'cha', 'チュ' => 'chu', 'チェ' => 'che', 'チョ' => 'cho',
    'ティ' => 'ty',  'テュ' => 'tyu', 'ディ' => 'dy',  'デュ' => 'dyu',
    'ニャ' => 'nya', 'ニュ' => 'nyu', 'ニョ' => 'nyo',
    'ファ' => 'fa',  'フィ' => 'fi',  'フェ' => 'fe',  'フォ' => 'fo',
    'ビャ' => 'bya', 'ビュ' => 'byu', 'ビョ' => 'byo',
    'ピャ' => 'pya', 'ピュ' => 'pyu', 'ピョ' => 'pyo',
    'ミャ' => 'mya', 'ミュ' => 'myu', 'ミョ' => 'myo',
    'リャ' => 'rya', 'リュ' => 'ryu', 'リョ' => 'ryo',
    'ア' => 'a',   'イ' => 'i',   'ウ' => 'u',   'エ' => 'e',   'オ' => 'o',
    'カ' => 'ka',  'キ' => 'ki',  'ク' => 'ku',  'ケ' => 'ke',  'コ' => 'ko',
    'サ' => 'sa',  'シ' => 'si',  'ス' => 'su',  'セ' => 'se',  'ソ' => 'so',
    'タ' => 'ta',  'チ' => 'chi', 'ツ' => 'tsu', 'テ' => 'te',  'ト' => 'to',
    'ナ' => 'na',  'ニ' => 'ni',  'ヌ' => 'nu',  'ネ' => 'ne',  'ノ' => 'no',
    'ハ' => 'ha',  'ヒ' => 'hi',  'フ' => 'fu',  'ヘ' => 'he',  'ホ' => 'ho',
    'マ' => 'ma',  'ミ' => 'mi',  'ム' => 'mu',  'メ' => 'me',  'モ' => 'mo',
    'ヤ' => 'ya',  'ユ' => 'yu',  'ヨ' => 'yo',
    'ラ' => 'ra',  'リ' => 'ri',  'ル' => 'ru',  'レ' => 're',  'ロ' => 'ro',
    'ワ' => 'wa',  'ン' => 'n',   'ヲ' => 'o',
    'ヴ' => 'v',
    'ガ' => 'ga',  'ギ' => 'gi',  'グ' => 'gu',  'ゲ' => 'ge',  'ゴ' => 'go',
    'ザ' => 'za',  'ジ' => 'ji',  'ズ' => 'zu',  'ゼ' => 'ze',  'ゾ' => 'zo',
    'ダ' => 'da',  'ヂ' => 'ji',  'ヅ' => 'zu',  'デ' => 'de',  'ド' => 'do',
    'バ' => 'ba',  'ビ' => 'bi',  'ブ' => 'bu',  'ベ' => 'be',  'ボ' => 'bo',
    'パ' => 'pa',  'ピ' => 'pi',  'プ' => 'pu',  'ペ' => 'pe',  'ポ' => 'po',
    'ァ' => 'a',   'ィ' => 'i',   'ゥ' => 'u',   'ェ' => 'e',   'ォ' => 'o',
    'ヵ' => 'ka',  'ヶ' => 'ki',  'ッ' => '',
    'ャ' => 'ya',  'ュ' => 'yu',  'ョ' => 'yo',  'ヮ' => 'wa',
    'ー' => '-',  '＿' => '_',  '！' => '',  '？' => '',
    '（' => '(',  '）' => ')',  '［' => '(',  '］' => ')'

);
