   function xjrExecute(handler) {
      var time = "The time is " + new Date();
      var data = {
         id: "timeDiv",
         text: time
      };
  
      handler(data);
   }

   com.bigllc.xjr.RequestDispatcher.notify();
