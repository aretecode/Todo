/**
 * 
 * @param  {} d .cb = callback, .m = method, .u = url, .d = data, .ct = contenttype
 * 
 */
function aj(d) {

	// make a XMLHttpRequest, hope it is not an old IE & FF browser
    var request = new XMLHttpRequest();
    
    // pass in a callback
    request.onreadystatechange = d.cb;

    // if the method is GET, add a `?` & the data
    request.open(d.m, d.u + (d.m == "GET" ? "?" + d.d : "") , true);
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    // use the contenttype
    request.setRequestHeader('Content-type', d.ct); 

    // send the data
    request.send(d.d);
}
