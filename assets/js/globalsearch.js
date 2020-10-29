var idx, searchInput, searchResults = null
var documents = []



function renderSearchResults(results){

    if (results.length > 0) {

        // show max 10 results
        if (results.length > 4){
            results = results.slice(0,5)
        }

        // reset search results
        searchResults.innerHTML = ''

        // append results
        results.forEach(result => {
        
            // create result item
            var article = document.createElement('article')
            article.innerHTML = `
            <a href="${result.ref}"><h3 class="title">${documents[result.ref].title}</h3></a>
            <p><a href="${result.ref}">${result.ref}</a></p>
            <br>
            `
            searchResults.appendChild(article)
        })

    // if results are empty
    } else {
        searchResults.innerHTML = '<div class="card-deck mt-4"><div class="card" style="background-color: #e5eef3;"><div class="card-body text-center"><p><span class="material-icons align-text-bottom">search_off</span> <b>Leider kein treffer!</b> <br>Versuchen Sie am besten gleich noch einmal oder kontaktieren Sie uns direkt unter <a class=\"link-text16\" href=\"mailto:cibsupport@cib.de\">cibsupport@cib.de</a></p></div ></div > '
    }
}

function registerSearchHandler() {

    // register on input event
    searchInput.oninput = function(event) {

        // remove search results if the user empties the search input field
        if (searchInput.value == '') {
            
            searchResults.innerHTML = ''
        } else {
            
            // get input value
            var query = event.target.value

            // run fuzzy search
            var results = idx.search(query + '*')

            // render results
            renderSearchResults(results)
        }
    }

    // set focus on search input and remove loading placeholder
    searchInput.focus()
    searchInput.placeholder = ''
}



function registerGlobalSearch(inputElement, resultsElement) {

    // get dom elements
    searchInput = document.getElementById(inputElement)
    searchResults = document.getElementById(resultsElement)

    // request and index documents
    fetch('/produkte/search.json', {
        method: 'get'
    }).then(
        res => res.json()
    ).then(
        res => {

            // index document
            idx = lunr(function() {
                this.ref('url')
                this.field('title')
                this.field('content')

                res.forEach(function(doc) {
                    this.add(doc)
                    documents[doc.url] = {
                        'title': doc.title,
                        'content': doc.content,
                    }
                }, this)
            })

            // data is loaded, next register handler
            registerSearchHandler()
        }
    ).catch(
        err => {
            searchResults.innerHTML = `<p>${err}</p>`
        }
    )
}


window.registerGlobalSearch = registerGlobalSearch