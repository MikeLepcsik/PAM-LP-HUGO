postsContainerDE = document.getElementById("newsContainer");
postsContainerES = document.getElementById("newsContainerES");
var HTMLStringDE = '';
var HTMLStringES = '';
var data;

function getPostDataRequestDE() {
    var ourRequest = new XMLHttpRequest();
    return new Promise(function (resolve, reject) {
        ourRequest.onreadystatechange = function () {
            if (ourRequest.readyState == 4) {
                if (ourRequest.status >= 300) {
                    reject("Error, status code = " + ourRequest.status)
                } else {
                    resolve(ourRequest.responseText);
                }
            }
        }
        ourRequest.open('GET', 'https://blog.cib.de/wp-json/wp/v2/posts?categories=605291165&per_page=3');
        ourRequest.send();
    });
}

function getPostDataRequestES() {
    var ourRequest = new XMLHttpRequest();
    return new Promise(function (resolve, reject) {
        ourRequest.onreadystatechange = function () {
            if (ourRequest.readyState == 4) {
                if (ourRequest.status >= 300) {
                    reject("Error, status code = " + ourRequest.status)
                } else {
                    resolve(ourRequest.responseText);
                }
            }
        }
        ourRequest.open('GET', 'https://blog.cib.de/wp-json/wp/v2/posts?categories=605291165&per_page=3');
        ourRequest.send();
    });
}

function createHtmlDE(postData) {
    var mediaUrl = 'https://blog.cib.de/wp-json/wp/v2/media/' + postData.featured_media;
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', mediaUrl, false);
    ourRequest.onload = function () {
        if (ourRequest.status >= 200 && ourRequest.status < 400) {
            imgData = JSON.parse(ourRequest.responseText);
            imgUrl = imgData.link;
        } else {
            console.log("We connected to the server, but it returned an error.");
        }
        HTMLStringDE += '<div id="newsItem" class="col-12 col-lg-4 pt-card pb-4">';
        HTMLStringDE += '<a target="_blank" href="' + postData.link + '"><img id="newsImg" class="img-fluid" src="' + imgUrl + '"></a>';
        HTMLStringDE += '<h3>' + postData.title.rendered + '</h3>';
        var content = strip_html_tags(postData.content.rendered);
        content = content.split(" ").splice(0, 30).join(" ");
        HTMLStringDE += '<div class="col text-left px-0">' + content + '...' + ' <a class="newsLinks" target="_blank" href="' + postData.link + '">[Mehr lesen]</a>' + '</div>';
        HTMLStringDE += '</div>';
        postsContainerDE.innerHTML = HTMLStringDE;
    };

    ourRequest.onerror = function () {
        console.log("Connection error");
    };
    ourRequest.send() 
}

function createHtmlES(postData) {
    var mediaUrl = 'https://blog.cib.de/wp-json/wp/v2/media/' + postData.featured_media;
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', mediaUrl, false);
    ourRequest.onload = function () {
        if (ourRequest.status >= 200 && ourRequest.status < 400) {
            imgData = JSON.parse(ourRequest.responseText);
            imgUrl = imgData.link;
        } else {
            console.log("We connected to the server, but it returned an error.");
        }
        HTMLStringES += '<div id="newsItem" class="col-12 col-lg-4 pt-card pb-4">';
        HTMLStringES += '<a target="_blank" href="' + postData.link + '"><img id="newsImg" class="img-fluid" src="' + imgUrl + '"></a>';
        HTMLStringES += '<h3>' + postData.title.rendered + '</h3>';
        var content = strip_html_tags(postData.content.rendered);
        content = content.split(" ").splice(0, 30).join(" ");
        HTMLStringES += '<div class="col text-left px-0">' + content + '...' + ' <a class="newsLinks" target="_blank" href="' + postData.link + '">[Leer más]</a>' + '</div>';
        HTMLStringES += '</div>';
        postsContainerES.innerHTML = HTMLStringES;
    };

    ourRequest.onerror = function () {
        console.log("Connection error");
    };
    ourRequest.send()
}

function strip_html_tags(str) {
    if ((str === null) || (str === ''))
        return false;
    else
        str = str.toString();
    return str.replace(/<[^>]*>/g, '');
}

if (postsContainerDE && postsContainerES) {
    getPostDataRequestDE().then(function (data) {
        posts = JSON.parse(data);
        for (i = 0; i < posts.length; i++) {
            console.log(posts[i]);
            createHtmlDE(posts[i]);
        }
    }, function (error) {
        console.log(error)
    }).then(function() {
        getPostDataRequestES().then(function (data) {
            posts = JSON.parse(data);
            for (i = 0; i < posts.length; i++) {
                console.log(posts[i]);
                createHtmlES(posts[i]);
            }
        }, function (error) {
            console.log(error)
        })
    })
}
