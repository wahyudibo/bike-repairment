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

  self.addEventListener('notificationclick', function(e) {
    var notification = e.notification;
    var action = e.action;

    if (action === 'close') {
      notification.close();
    }

    self.registration.getNotifications().then(function(notifications) {
      notifications.forEach(function(notification) {
        notification.close();
      });
    });
  });

  self.addEventListener('push', function(e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
      return;
    }

    if (e.data) {
      var data = e.data.json();

      if (data.id) {
        self.registration.pushManager.getSubscription()
        .then(function(subscription) {
          if (subscription) {
            return subscription.unsubscribe();
          }
        })
      }

      self.registration.showNotification(data.title, {
        body: data.body,
        icon: data.icon
      });
    }
  });

})();
