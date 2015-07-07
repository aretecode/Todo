/**
 * 
 * @param  array<string, element> params 
 * @return string
 * 
 */
function optionElementsParameterAdapter(params) {
    for 
    (
        var i = 0, 
        postBody = ""; i < params.length;
        postBody +=
        (
            params[i].getAttribute("name") + '=' + 
            encodeURIComponent(params[i].options[params[i].selectedIndex].value)
        ),
  
        i++
    );

    return urlParams.substring(0, urlParams.length - 1);
}