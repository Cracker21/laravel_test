"use strict"

window.addEventListener('DOMContentLoaded', async (e)=>{
  for(let i = 0;i<document.forms.length;i++){
		document.forms[i].onsubmit = async (e)=>{
    		e.preventDefault();
    		let data = new FormData(e.target);
    		let rslt = await request(e.target.action, data)
	   }
    }
})

async function request(act, data){
    let response = await fetch(act, {
      	method: 'POST',
      	body: data
   	});

    let res = await response.json();
    
    if(res.msg == 'unauth')
        location.href = 'auth';
    if(res.msg == 'ok')
        location.href = 'deal';
    msg.innerHTML = res.msg;
    setTimeout(()=>{
        msg.innerHTML="";
    },4000);
}