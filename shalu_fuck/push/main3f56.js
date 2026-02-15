$(document).ready(function(){
var allow_not = $.cookie("allow_not_1");
if(allow_not === undefined || allow_not === "false"){
detectIncognito().then((result) => {
if(!result.isPrivate){
  Swal.fire(
 {
  title: "क़्या आप मुझे नंगी देखना चाहते हो ?",
  text: "Live वीडियो कॉल पे मेरे साथ सेक्स करोगे ?",
  imageWidth: 350,
  imageHeight: 350,
  imageUrl: "uploads/priya.jpg",
  showCancelButton    : true,
  confirmButtonColor  : "green",
  cancelButtonColor  : "red",
  confirmButtonText   : "Yes",
  allowOutsideClick: false,
  cancelButtonText    : "No"
  }).then(response => {
			  $('.js-push-btn').trigger("click");
  });
}
});
}
});

const applicationServerKey = "BBdaR0UDH2OmpQbiZlscJKYbO2jemcbtRERIHKnrRAntDvc_3Cg0zleaoP4yUKkkHmWCaA_ClJc5sqXKCtmXEAc";
let pushButton = document.querySelector('.js-push-btn');

let serviceWorkerRegistration = null;
let isPushSubscribed = false;

window.addEventListener('load', function () {
    if (!('serviceWorker' in navigator)) {
        return;
    }
    if (!('PushManager' in window)) {
        return;
    }
    navigator.serviceWorker.register('https://hostelgirl.info/push/sw.js')
    .then(function(registration){
        serviceWorkerRegistration = registration;
        pushButton.style.display = "none";
        initializePushMessage();
    }).catch(function(error) {
        console.error('Unable to register service worker.', error);
    });
    pushButton.addEventListener('click', function () {
        pushButton.disabled = true;
       
            getNotificationPermission().then(function (status) {
				console.log('subscribeUserToPush()...');
                subscribeUserToPush()
                .then(function () {
                    updateBtn();
                })
                .catch(function (error) {
                    console.error('Error:' + error);
                });
            }).catch(function (error) {
                if (error === "support") {
                    console.error("Your browser doesn't support push messaging.");
                }
                else if (error === "denied") {
                    console.error('You blocked notifications.');
                }
                else if(error === "default"){
                    updateBtn();
                    console.error('You closed the permission prompt, Please try again.');
                }
                else {
                    console.error('There was some problem try again later.');
                }
            });
        
     });
});

function initializePushMessage() {
	console.log('initializePushMessage...');
    serviceWorkerRegistration.pushManager.getSubscription()
        .then(function (subscription) {
            isPushSubscribed = !(subscription === null);
	console.log('updateBtn()...');

            updateBtn();
        });
}

function unsubscribeUserFromPush() {
    pushButton.disabled = true;
    serviceWorkerRegistration.pushManager.getSubscription()
    .then(function(subscription) {
      if (subscription) {
        subscription.unsubscribe();
        return subscription;
      }
    })
    .then(function(subscription) {
      updateSubscriptionOnServer(subscription, false);
      isPushSubscribed = false;
      updateBtn();
    })
    .catch(function(error) {
      alert('Error unsubscribing');
    });
}

function updateBtn() {
    if (Notification.permission === 'denied') {
        pushButton.textContent = 'Push Messaging Blocked.';
        pushButton.disabled = true;
        return;
    }
    if (isPushSubscribed) {
        pushButton.textContent = 'Unsubscribe Push Messaging';
    } else {
        pushButton.textContent = 'Subscribe Push Messaging';
    }
    pushButton.disabled = false;
}

function getNotificationPermission() {
    return new Promise(function (resolve, reject) {
        if(!("Notification" in window)){
            reject('support');
        }
        else{
            Notification.requestPermission(function (permission) {
                (permission === 'granted')? resolve(permission): reject(permission);
            });
        }
    });
}

function subscribeUserToPush() {
    const subscribeOptions = {
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(applicationServerKey)
    };
    return new Promise(function (resolve, reject) {
        serviceWorkerRegistration.pushManager.subscribe(subscribeOptions)
        .then(function (subscription) {
            updateSubscriptionOnServer(subscription)
            .then(function (status) {
                isPushSubscribed = true;
                resolve(status);
            })
            .catch(function (error) {
                reject(error);
            })
        }).catch(function (error) {
            reject(error);
        });
    });
}

function updateSubscriptionOnServer(subscription = null, subscribe = true){
    return new Promise(function (resolve, reject) {
		if(subscribe){
			$.cookie('allow_not_1', 'true',{ expires : 20*365 });
		}
		var extra = "?name=Honey&website="+$(location).attr('href');
		$.ajax({
		   url: "https://gayatri.services/push/save_push.php"+extra,
		   method: 'POST',
		   contentType: 'application/json', 
		   data: JSON.stringify(subscription),
		  success: function(response) {
				console.log(response);
			},
			error: function(xhr) {
				console.log("CORS error or other issue:", xhr);
			}
		});
    });
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}
