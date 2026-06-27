(function(){
  const loader=document.querySelector('.premium-loader');
  window.addEventListener('load',()=>{setTimeout(()=>loader&&loader.classList.add('hide'),450)});

  const menu=document.querySelector('.menu-toggle');
  const nav=document.querySelector('.nav-links');
  if(menu&&nav){menu.addEventListener('click',()=>nav.classList.toggle('open'));}

  const current=location.pathname.split('/').pop()||'index.php';
  document.querySelectorAll('.nav-links a').forEach(a=>{if((a.getAttribute('href')||'')===current)a.classList.add('active')});

  if(window.gsap){
    const hasScrollTrigger = !!window.ScrollTrigger;
    if(hasScrollTrigger) gsap.registerPlugin(window.ScrollTrigger);
    gsap.to('.hero-card',{y:-18,rotateY:6,duration:5,repeat:-1,yoyo:true,ease:'sine.inOut'});
    gsap.utils.toArray('.reveal').forEach(el=>{
      const cfg={opacity:1,y:0,duration:.9,ease:'power2.out'};
      if(hasScrollTrigger) cfg.scrollTrigger={trigger:el,start:'top 86%'};
      gsap.to(el,cfg);
    });
    gsap.utils.toArray('.stat strong').forEach(num=>{
      const val=parseInt(num.dataset.count||num.textContent,10)||0;
      const cfg={innerText:val,duration:2,snap:{innerText:1}};
      if(hasScrollTrigger) cfg.scrollTrigger={trigger:num,start:'top 88%'};
      gsap.fromTo(num,{innerText:0},cfg);
    });
  }else{
    document.querySelectorAll('.reveal').forEach(el=>{el.style.opacity=1;el.style.transform='none'});
  }

  const hero=document.querySelector('.hero');
  if(hero){
    hero.addEventListener('mousemove',e=>{
      const x=(e.clientX/window.innerWidth-.5)*16;
      const y=(e.clientY/window.innerHeight-.5)*16;
      document.querySelectorAll('[data-parallax]').forEach(el=>{el.style.transform=`translate3d(${x}px,${y}px,0)`});
    });
  }

  const filterBtns=document.querySelectorAll('.filter-btn');
  const items=document.querySelectorAll('[data-category]');
  filterBtns.forEach(btn=>btn.addEventListener('click',()=>{
    filterBtns.forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    const f=btn.dataset.filter;
    items.forEach(item=>{
      item.style.display=(f==='all'||item.dataset.category===f)?'block':'none';
    });
  }));

  const lightbox=document.querySelector('.lightbox');
  const close=document.querySelector('.lightbox-close');
  if(lightbox){
    document.querySelectorAll('[data-lightbox]').forEach(el=>el.addEventListener('click',()=>{
      const type=el.dataset.type||'image';
      const src=el.dataset.src;
      const box=lightbox.querySelector('.lightbox-content');
      if(!src||!box) return;
      box.innerHTML= type==='video' ? `<video src="${src}" controls autoplay playsinline></video>` : `<img src="${src}" alt="Wedding Shedding Gallery">`;
      lightbox.classList.add('open');
    }));
    close&&close.addEventListener('click',()=>{lightbox.classList.remove('open');const box=lightbox.querySelector('.lightbox-content');if(box)box.innerHTML='';});
    lightbox.addEventListener('click',e=>{if(e.target===lightbox){lightbox.classList.remove('open');const box=lightbox.querySelector('.lightbox-content');if(box)box.innerHTML='';}});
  }

  initWeddingScene();
})();

function initWeddingScene(){
  const canvas=document.getElementById('weddingScene');
  if(!canvas||!window.THREE) return;
  const scene=new THREE.Scene();
  const camera=new THREE.PerspectiveCamera(55,window.innerWidth/window.innerHeight,.1,1000);
  camera.position.set(0,0,62);
  const renderer=new THREE.WebGLRenderer({canvas,alpha:true,antialias:true});
  renderer.setSize(window.innerWidth,window.innerHeight);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));

  const group=new THREE.Group();
  scene.add(group);

  const petalGeometry=new THREE.PlaneGeometry(1.25,.72,1,1);
  const petalMaterial=new THREE.MeshBasicMaterial({color:0xf7d6d9,transparent:true,opacity:.72,side:THREE.DoubleSide});
  const goldMaterial=new THREE.MeshBasicMaterial({color:0xd4af37,transparent:true,opacity:.58});
  const petals=[];
  for(let i=0;i<95;i++){
    const mesh=new THREE.Mesh(petalGeometry,petalMaterial.clone());
    mesh.position.set((Math.random()-.5)*95,(Math.random()-.5)*60,(Math.random()-.5)*70);
    mesh.rotation.set(Math.random()*Math.PI,Math.random()*Math.PI,Math.random()*Math.PI);
    mesh.userData={speed:.018+Math.random()*.032,spin:.006+Math.random()*.018};
    group.add(mesh);petals.push(mesh);
  }
  const particleGeometry=new THREE.BufferGeometry();
  const positions=[];
  for(let i=0;i<230;i++) positions.push((Math.random()-.5)*110,(Math.random()-.5)*70,(Math.random()-.5)*80);
  particleGeometry.setAttribute('position',new THREE.Float32BufferAttribute(positions,3));
  const particles=new THREE.Points(particleGeometry,new THREE.PointsMaterial({color:0xd4af37,size:.28,transparent:true,opacity:.72}));
  group.add(particles);

  const light1=new THREE.PointLight(0xfff8ee,1.8,140);light1.position.set(22,18,28);scene.add(light1);
  const light2=new THREE.PointLight(0xf7d6d9,1.2,120);light2.position.set(-28,-14,36);scene.add(light2);

  let mx=0,my=0;
  window.addEventListener('mousemove',e=>{mx=(e.clientX/window.innerWidth-.5);my=(e.clientY/window.innerHeight-.5)});
  window.addEventListener('resize',()=>{camera.aspect=window.innerWidth/window.innerHeight;camera.updateProjectionMatrix();renderer.setSize(window.innerWidth,window.innerHeight)});

  function tick(){
    petals.forEach(p=>{
      p.position.y-=p.userData.speed;
      p.position.x+=Math.sin(Date.now()*.0008+p.position.z)*.012;
      p.rotation.x+=p.userData.spin;p.rotation.z+=p.userData.spin*.7;
      if(p.position.y<-36){p.position.y=36;p.position.x=(Math.random()-.5)*95;}
    });
    particles.rotation.y+=.0009;
    group.rotation.y+=((mx*.12)-group.rotation.y)*.03;
    group.rotation.x+=((-my*.08)-group.rotation.x)*.03;
    camera.position.x+=((mx*3)-camera.position.x)*.025;
    camera.position.y+=((-my*2)-camera.position.y)*.025;
    camera.lookAt(0,0,0);
    renderer.render(scene,camera);
    requestAnimationFrame(tick);
  }
  tick();
}
