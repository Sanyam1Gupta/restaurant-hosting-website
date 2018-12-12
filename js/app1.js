var config = {
    apiKey: "AIzaSyAdMgb_obwFuQKGDOZdvxlj1rTvi40D6F0",
    authDomain: "se-proj-626d7.firebaseapp.com",
    databaseURL: "https://se-proj-626d7.firebaseio.com",
    projectId: "se-proj-626d7",
    storageBucket: "se-proj-626d7.appspot.com",
    messagingSenderId: "875448971637"
  };
  firebase.initializeApp(config);
  var db = firebase.firestore();
  db.settings({
    timestampsInSnapshots: true
  });

  //const outputHeader = document.querySelector("#Reserve Table");
  const firstName = document.querySelector("#firstname");
  const lastName = document.querySelector("#lastname");
  const areaCode = document.querySelector("#areacode");
  const telNum = document.querySelector("#telnum");
  const emailId = document.querySelector("#emailid");
  const feedBack = document.querySelector("#feedback");
  const feedBack_Button = document.querySelector("#feedback_button");
  console.log("testing...testing...before");

  feedBack_Button.addEventListener("click", (e) => {
    console.log("testing...testing...");
    db.collection("feedback").add({
       FirstName: firstName.value,
       LastName: lastName.value,
       AreaCode: areaCode.value,
       TelNum: telNum.value,
       EmailId: emailId.value,
       Feedback: feedBack.value
    }).then(function(){
        console.log("Status saved");
    }).catch(function(error){
        console.log("ERROR...ERROR...", error);
    });
  })
  

