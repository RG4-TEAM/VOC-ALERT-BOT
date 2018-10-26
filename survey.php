<html>
  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>LIFF Starter</title>
      <link rel="stylesheet" href="style.css">
  </head>

  <body>
      <div class="buttongroup">
          <div class="buttonrow">
              <button id="openwindowbutton">Open Window</button>
              <button id="closewindowbutton">Close Window</button>
          </div>
          <div class="buttonrow">
              <button id="getprofilebutton">Get Profile</button>
              <button id="sendmessagebutton">Send Message</button>
          </div>
      </div>

      <div id="profileinfo">
          <h2>Profile</h2>
          <a href="#" onclick="toggleProfileData()">Close Profile</a>
          <div id="profilepicturediv">
          </div>
          <table border="1">
              <tr>
                  <th>userId</th>
                  <td id="useridprofilefield"></td>
              </tr>
              <tr>
                  <th>displayName</th>
                  <td id="displaynamefield"></td>
              </tr>
              <tr>
                  <th>statusMessage</th>
                  <td id="statusmessagefield"></td>
              </tr>
          </table>
      </div>

      <div id="liffdata">
          <h2>LIFF Data</h2>
          <table border="1">
              <tr>
                  <th>language</th>
                  <td id="languagefield"></td>
              </tr>
              <tr>
                  <th>context.viewType</th>
                  <td id="viewtypefield"></td>
              </tr>
              <tr>
                  <th>context.userId</th>
                  <td id="useridfield"></td>
              </tr>
              <tr>
                  <th>context.utouId</th>
                  <td id="utouidfield"></td>
              </tr>
              <tr>
                  <th>context.roomId</th>
                  <td id="roomidfield"></td>
              </tr>
              <tr>
                  <th>context.groupId</th>
                  <td id="groupidfield"></td>
              </tr>
          </table>
      </div>
      
      <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
      <script>
      window.onload = function (e) {
        liff.init(function (data) {
            initializeApp(data);
        });
      };
      function initializeApp(data) {
          document.getElementById('languagefield').textContent = data.language;
          document.getElementById('viewtypefield').textContent = data.context.viewType;
          document.getElementById('useridfield').textContent = data.context.userId;
          document.getElementById('utouidfield').textContent = data.context.utouId;
          document.getElementById('roomidfield').textContent = data.context.roomId;
          document.getElementById('groupidfield').textContent = data.context.groupId;

          // openWindow call
          document.getElementById('openwindowbutton').addEventListener('click', function () {
              liff.openWindow({
                  url: 'https://line.me'
              });
          });

          // closeWindow call
          document.getElementById('closewindowbutton').addEventListener('click', function () {
              liff.closeWindow();
          });

          // sendMessages call
          document.getElementById('sendmessagebutton').addEventListener('click', function () {
              liff.sendMessages([{
                  type: 'text',
                  text: "You've successfully sent a message! Hooray!"
              }, {
                  type: 'sticker',
                  packageId: '2',
                  stickerId: '144'
              }]).then(function () {
                  window.alert("Message sent");
              }).catch(function (error) {
                  window.alert("Error sending message: " + error);
              });
          });

          //get profile call
          document.getElementById('getprofilebutton').addEventListener('click', function () {
              liff.getProfile().then(function (profile) {
                  document.getElementById('useridprofilefield').textContent = profile.userId;
                  document.getElementById('displaynamefield').textContent = profile.displayName;

                  var profilePictureDiv = document.getElementById('profilepicturediv');
                  if (profilePictureDiv.firstElementChild) {
                      profilePictureDiv.removeChild(profilePictureDiv.firstElementChild);
                  }
                  var img = document.createElement('img');
                  img.src = profile.pictureUrl;
                  img.alt = "Profile Picture";
                  profilePictureDiv.appendChild(img);

                  document.getElementById('statusmessagefield').textContent = profile.statusMessage;
                  toggleProfileData();
              }).catch(function (error) {
                  window.alert("Error getting profile: " + error);
              });
          });
      }

      function toggleProfileData() {
          var elem = document.getElementById('profileinfo');
          if (elem.offsetWidth > 0 && elem.offsetHeight > 0) {
              elem.style.display = "none";
          } else {
              elem.style.display = "block";
          }
      }
      </script>
  </body>
</html>