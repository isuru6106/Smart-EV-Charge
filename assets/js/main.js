function qs(id){ return document.getElementById(id); }

async function api(url, options={}){
  const res = await fetch(url, options);
  return await res.json();
}

function setDemoLocation(){
  localStorage.setItem("demo_lat","6.9271");
  localStorage.setItem("demo_lng","79.8612");
}

function logout(){
  localStorage.clear();
  window.location.href="../login.html";
}
