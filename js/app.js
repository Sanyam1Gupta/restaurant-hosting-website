var config = {
    apiKey: "AIzaSyAdMgb_obwFuQKGDOZdvxlj1rTvi40D6F0",
    authDomain: "se-proj-626d7.firebaseapp.com",
    databaseURL: "https://se-proj-626d7.firebaseio.com",
    projectId: "se-proj-626d7",
    storageBucket: "se-proj-626d7.appspot.com",
    messagingSenderId: "875448971637"
  };
  firebase.initializeApp(config);
  const db = firebase.firestore();
  db.settings({
    timestampsInSnapshots: true
  });

  //const outputHeader = document.querySelector("#Reserve Table");
 // const inputName = document.querySelector("#User");
  //const inputGuests = document.querySelector("#Guests");
  //const inputSection = document.querySelector("#Section");
  //const inputDate = document.querySelector("#date");
  //const inputTime = document.querySelector("#time");
  //const reserveButton = document.querySelector("#Reserve");
  //console.log("testing...testing...before");

  //reserveButton.addEventListener("click", function() {
    //const nameToSave =inputName.value;
    //const guestsToSave =inputGuests.value;
   // const sectionToSave =inputSection.value;
    //const dateToSave =inputDate.value;
    //const timeToSave =inputTime.value;
    console.log("testing...testing...");
    db.collection("samples").add({
       UserName: name,
       NumberGuests: guest,
       Section: section,
       Date: date,
       Time: time
    }).then(function(){
        console.log("Status saved");
    }).catch(function(error){
        console.log("ERROR...ERROR...", error);
    });
  

