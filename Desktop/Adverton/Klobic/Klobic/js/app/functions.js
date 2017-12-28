function toggleClass(elem) {
    $('.LabelButton__selected').removeClass('LabelButton__selected');
    $(elem).toggleClass('LabelButton__selected');
};

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

function getParameterByName(name, url) {
  if (!url) url = window.location.href;
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return '';
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getCaretPosition(editableDiv) {
  var caretPos = 0,
    sel, range;
  if (window.getSelection) {
    sel = window.getSelection();
    if (sel.rangeCount) {
      range = sel.getRangeAt(0);
      if (range.commonAncestorContainer.parentNode == editableDiv) {
        caretPos = range.endOffset;
      }
    }
  } else if (document.selection && document.selection.createRange) {
    range = document.selection.createRange();
    if (range.parentElement() == editableDiv) {
      var tempEl = document.createElement("span");
      editableDiv.insertBefore(tempEl, editableDiv.firstChild);
      var tempRange = range.duplicate();
      tempRange.moveToElementText(tempEl);
      tempRange.setEndPoint("EndToEnd", range);
      caretPos = tempRange.text.length;
    }
  }
  return caretPos;
}

function placeCaretAt(el, position) {
    var textNode = el.firstChild;
    el.focus();
    
    if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
        var range = document.createRange();
        
        if(position){
            range.setStart(textNode, position);
            range.setEnd(textNode, position);
        } else {
            range.selectNodeContents(el);
            range.collapse(false);
        }
        
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (typeof document.body.createTextRange != "undefined") {
        var textRange = document.body.createTextRange();
        
        if(position){
            textRange.setStart(textNode, position);
            textRange.setEnd(textNode, position);
        } else {
            textRange.moveToElementText(el);
            textRange.collapse(false);
        }
        
        textRange.select();
    }
}

function object_length(M) {
    var N = 0,
        L;
    for (L in M) {
        if (M.hasOwnProperty(L)) {
            N++
        }
    };
    return N;
}

function nl2br(K) {
    var J = "<br/>";
    return (K + "").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, "$1" + J + "$2");
}

function SaveToLocal(par,val)
	{
	window.localStorage.setItem(app_title+'_'+par,val);
	}
	
function RemoveFromLocal(par)
	{
	window.localStorage.removeItem(app_title+'_'+par);
	}

function GetFromLocal(par)
	{
	return window.localStorage.getItem(app_title+'_'+par);	
	}
	
function exists(string)
	{
	if ((typeof string=='undefined') || (string==null) || (string==''))	
		{
			return false	
		}else{
			return true	
		}
	}
	
function GetNumberFromString(string)
	{
	if (string)
		{
		return parseInt(string.replace(/[^0-9-]/g,''))|0;
		}else{
		return 0;	
		}
	}
	
function nl2br(str, is_xhtml) 
	{
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}

function sortNumber(a,b) {//sort function for sorting arrays with numbers ARRAY.sort(sortNumber)
    return a - b;
}

function get_mouse_pos(selector)
	{
	var pos=$(selector).offset();
	return {"x":currentMousePos.x-pos.left,"y":currentMousePos.y-pos.top}
	}

/*Helper function to extract the URL between the last / and before ? 
  If url is www.example.com/file.php?f_id=55 this function will return file.php 
 pseudo code: edit to match your url settings  
*/ 
function refineUrl()
{
    //get full url
    var url = window.location.href;
    //get url after/  
    var value = url.substring(url.lastIndexOf('/') + 1);
    //get the part after before ?
    value  = value.split("?")[0];   
    return value;     
}

function ValidURL(str) {
  var pattern = new RegExp('^(https?:\/\/)?'+ // protocol
    '((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|'+ // domain name
    '((\d{1,3}\.){3}\d{1,3}))'+ // OR ip (v4) address
    '(\:\d+)?(\/[-a-z\d%_.~+]*)*'+ // port and path
    '(\?[;&a-z\d%_.~+=-]*)?'+ // query string
    '(\#[-a-z\d_]*)?$','i'); // fragment locater
  if(!pattern.test(str)) {
    alert("Please enter a valid URL.");
    return false;
  } else {
    return true;
  }
}