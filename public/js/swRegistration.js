/*
Copyright 2016 Google Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/
var app = (function() {
  'use strict';

  var swRegistration = null;
  var startButton = document.getElementById('startBtn');

  if (!('Notification' in window)) {
    console.log('This browser does not support notifications!');
    return;
  }

  Notification.requestPermission(function(status) {
    console.log('Notification permission status:', status);
  });

  var applicationServerPublicKey = 'BALHadv2QjvyHgM/HzHRQpHwcXuO1OTko9pR/+VcuISWmJBodzcL2LMld6qgmYJw1TBfD0503zfA4oTGAaOt0EE=';

  function subscribeUser() {
    var applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
    swRegistration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: applicationServerKey
    })
    .then(function(subscription) {
      console.log('User is subscribed:', subscription);
      updateSubscriptionOnServer(subscription);
    })
    .catch(function(err) {
      if (Notification.permission === 'denied') {
        console.warn('Permission for notifications was denied');
      } else {
        console.error('Failed to subscribe the user: ', err);
      }
    });
  }

  function unsubscribeUser() {
    swRegistration.pushManager.getSubscription()
    .then(function(subscription) {
      if (subscription) {
        return subscription.unsubscribe();
      }
    })
    .catch(function(error) {
      console.log('Error unsubscribing', error);
    })
    .then(function() {
      updateSubscriptionOnServer(null);

      console.log('User is unsubscribed');
    });
  }

  function updateSubscriptionOnServer(subscription) {
    if (subscription) {
      document.getElementById('subscription').value = JSON.stringify(subscription);
    }
  }

  function urlB64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
      .replace(/\-/g, '+')
      .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
  }

  startButton.addEventListener('click', function() {
    subscribeUser();
  });

  if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('sw.js')
    .then(function(swReg) {
      console.log('Service Worker is registered', swReg);

      swRegistration = swReg;
    })
    .catch(function(error) {
      console.error('Service Worker Error', error);
    });
  } else {
    console.warn('Push messaging is not supported');
  }

})();
