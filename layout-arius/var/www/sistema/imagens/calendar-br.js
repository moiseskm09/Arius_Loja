// ** I18N

// Calendar EN language
// Author: Mihai Bazon, <mihai_bazon@yahoo.com>
// Encoding: any
// Distributed under the same terms as the calendar itself.

// For translators: please use UTF-8 if possible.  We strongly believe that
// Unicode is the answer to a real internationalized world.  Also please
// include your contact information in the header, as can be seen above.

// full day names
Calendar._DN = new Array
("Domingo",
 "Segunda",
 "Ter�a",
 "Quarta",
 "Quinta",
 "Sexta",
 "Sabado",
 "Domingo");

// Please note that the following array of short day names (and the same goes
// for short month names, _SMN) isn't absolutely necessary.  We give it here
// for exemplification on how one can customize the short day names, but if
// they are simply the first N letters of the full name you can simply say:
//
//   Calendar._SDN_len = N; // short day name length
//   Calendar._SMN_len = N; // short month name length
//
// If N = 3 then this is not needed either since we assume a value of 3 if not
// present, to be compatible with translation files that were written before
// this feature.

// short day names
Calendar._SDN = new Array
("Dom",
 "Seg",
 "Ter",
 "Qua",
 "Qui",
 "Sex",
 "Sab",
 "Dom");

// First day of the week. "0" means display Sunday first, "1" means display
// Monday first, etc.
Calendar._FD = 0;

// full month names
Calendar._MN = new Array
("Janeiro",
 "Fevereiro",
 "Mar�o",
 "Abril",
 "Maio",
 "Junho",
 "Julho",
 "Agosto",
 "Setembro",
 "Outubro",
 "Novembro",
 "Dezembro");

// short month names
Calendar._SMN = new Array
("Jan",
 "Fev",
 "Mar",
 "Abr",
 "Mai",
 "Jun",
 "Jul",
 "Ago",
 "Set",
 "Out",
 "Nov",
 "Dez");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "Sobre o calend�rio";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Autor: Mihai Bazon\n" + // don't translate this this ;-)
"Para �ltima vers�o visite: http://www.dynarch.com/projects/calendar/\n" +
"Distribuido sobre GNU LGPL.  Veja http://gnu.org/licenses/lgpl.html para maiores detalhes." +
"\n\n" +
"Sele��o da data:\n" +
"- Use os bot�es \xab, \xbb para selecionar o ano\n" +
"- Use os bot�es " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " para selecionar o m�s\n" +
"- Segure o bot�o do mouse sobre qualquer um dos bot�es acima para sele��o r�pida.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Sele��o da hora:\n" +
"- Clique em qualquer uma das partes da hora para adiant�-la\n" +
"- ou combinando com o bot�o Shift para atras�-la\n" +
"- ou clique e arraste para sele��o r�pida.";

Calendar._TT["PREV_YEAR"] = "Ano anterior (segure para menu)";
Calendar._TT["PREV_MONTH"] = "M�s anterior (segure para menu)";
Calendar._TT["GO_TODAY"] = "V� para Hoje";
Calendar._TT["NEXT_MONTH"] = "Pr�ximo m�s (segure para menu)";
Calendar._TT["NEXT_YEAR"] = "Pr�ximo ano (segure para menu)";
Calendar._TT["SEL_DATE"] = "Seleciona data";
Calendar._TT["DRAG_TO_MOVE"] = "Arraste para mover";
Calendar._TT["PART_TODAY"] = " (hoje)";

// the following is to inform that "%s" is to be the first day of week
// %s will be replaced with the day name.
Calendar._TT["DAY_FIRST"] = "Mostra %s primeiro";

// This may be locale-dependent.  It specifies the week-end days, as an array
// of comma-separated numbers.  The numbers are from 0 to 6: 0 means Sunday, 1
// means Monday, etc.
Calendar._TT["WEEKEND"] = "0,6";

Calendar._TT["CLOSE"] = "Fechar";
Calendar._TT["TODAY"] = "Hoje";
Calendar._TT["TIME_PART"] = "(Shift-)Clique ou arraste para mudar o valor";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%d/%m/%Y";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %b %e";

Calendar._TT["WK"] = "wk";
Calendar._TT["TIME"] = "Hora:";
