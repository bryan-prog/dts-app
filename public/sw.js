
/// for testing to be updated
self.addEventListener("install", function (event){
    event.waitUntil(preLoad()); 
})

var filesToCache = [
    '/',
    '/home',
    '/offline.html',
    
];

var preLoad = function (){
    return caches.open("offline").then(function (cache){
        return cache.addAll(filesToCache);
    });
}

self.addEventListener("fetch", function (event){
    event.respondWith(checkResponse(event.request).catch(function (){
        return returnFromCache(event.request);
    }));
    event.waitUntil(addToCache(event.request)); 
});

var checkResponse = function (request){
    return new Promise(function (fullfill, reject){
        fetch(request).then(function (response){
            if(response.status !== 404){
                fullfill(response);
            }else{
                reject();
            }
        }, reject)
    });
}

var addToCache = function (request){
    return caches.open("offline").then(function (cache){
        return fetch(request).then(function (response){
            return cache.put(request, response)
        })
    })
}

var returnFromCache = function (request){
    return caches.open("offline").then(function (cache){
        return cache.match(request).then(function (matching){
            if(!matching || matching.status == 404){
                return cache.match("offline.html");
            } else {
                return matching; 
            }
        });
    });
}