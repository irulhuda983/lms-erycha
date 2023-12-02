import{o as s,c as o,d as e,m as n,t as l,F as c,a as D,n as I,r as d,l as M,i as A,s as b,w as f,x as w}from"./app-cf61ecef.js";const T="/build/assets/materi_icon-9ae1060a.png",B="/build/assets/lms_icon-5a5fec6f.jpg",v="/build/assets/ilustrasi-639aa8bd.png",R={class:"hidden lg:flex w-full h-[320px] rounded-3xl shadow-lg bg-[#5072EE] relative box-border py-12 shadow-xl px-6"},N={id:"svg",class:"w-1/2 mr-2"},C=["src"],W={class:"text-white font-bold w-1/2"},U=e("p",{class:"font-medium text-[20px] mb-1"},"Selamat Datang",-1),K={class:"font-semibold text-[28px] mb-4 capitalize"},L=e("p",{class:"font-medium text-[13px] mb-2 text-gray-100"},"Mari kita mulai hari ini dengan mempelajari sesuatu sekarang. Jangan lupa memeriksa daftar materi yang tersedia. Semoga harimu menyenangkan.",-1),z={class:"block lg:hidden w-full h-[170px] rounded-xl shadow-lg bg-[#5072EE] relative box-border p-4 shadow-xl overflow-hidden relative"},H={class:"w-full text-white box-border"},O=e("p",{class:"font-medium text-base mb-1"},"Selamat Datang",-1),V={class:"font-semibold text-lg mb-4 capitalize"},G=e("p",{class:"font-medium text-[13px] mb-2 text-gray-100 pr-32 box-border"},"Mari kita mulai hari ini dengan mempelajari sesuatu sekarang.",-1),J={id:"svg",class:"w-32 h-32 absolute -bottom-12 right-0"},P=["src"],q={__name:"BannerHome",props:["user"],setup(_){return(x,u)=>(s(),o(c,null,[e("div",R,[e("div",N,[e("img",{src:n(v),alt:""},null,8,C)]),e("div",W,[U,e("p",K,l(_.user.nama),1),L])]),e("div",z,[e("div",H,[O,e("p",V,l(_.user.nama),1),G]),e("div",J,[e("img",{src:n(v),alt:"",class:"w-full"},null,8,P)])])],64))}},Q={class:"w-full box-border overflow-x-hidden h-full pt-[80px] px-4"},X={class:"w-full box-border mb-4 lg:flex overflow-hidden mb-5"},Y={class:"w-full lg:w-3/5 box-border lg:mr-5 mb-5 lg:mb-0"},Z={class:"lg:w-2/5 h-full box-border overflow-hidden"},ee={class:"w-full box-border grid grid-cols-2 grid-rows-2 gap-4"},te={class:"rounded-full bg-white w-10 h-10 flex items-center justify-center mb-3 overflow-hidden"},se=["src"],oe={class:"text-gray-800 font-semibold text-sm lg:text-base mb-1"},le={class:"w-full bg-white/50 box-border px-2 py-1 lg:px-2 py-2 text-[10px] font-medium rounded-[7px] backdrop-blur-md"},ae={class:"w-full box-border lg:flex mb-24"},ie={class:"w-full lg:w-2/5 box-border bg-white p-3 box-border rounded lg:mr-5 mb-5 lg:mb-0"},re=e("div",{class:"flex items-center justify-between mb-4"},[e("h1",{class:"text-base text-[#222222] font-semibold"},"Hasil Ujian Tertinggi")],-1),ne={class:"w-full box-border"},de={class:"w-full"},ce=e("thead",null,[e("tr",null,[e("td",{class:"px-2 py-3 w-[80px] border-b"},"Rank"),e("td",{class:"px-2 py-3 border-b"},"Nama"),e("td",{class:"px-2 py-3 border-b w-[20px] text-end"},"Point")])],-1),ue={key:0},be={class:"px-2 py-3 border-b"},_e={class:"w-6 h-6 bg-[#FDD0D5] rounded-[4px] flex items-center justify-center text-white text-[12px]"},he={class:"px-2 py-3 border-b"},me={class:"text-[8px] text-gray-500"},xe={class:"px-2 py-3 border-b font-semibold w-[20px] text-end"},ge={key:1},pe=e("tr",null,[e("td",{class:"px-2 py-3 border-b text-center italic",colspan:"3"}," Belum ada hasil ujian ")],-1),fe=[pe],we={class:"w-full lg:w-2/5 box-border bg-white p-3 box-border rounded lg:mr-5 mb-5 lg:mb-0"},ve={class:"flex items-center justify-between mb-4"},ye=e("h1",{class:"text-base text-[#222222] font-semibold"},"Materi Terbaru",-1),Se={key:0,class:"w-full box-border"},ke=["onClick"],Fe={class:"w-12 h-12 bg-white flex-none rounded flex items-center justify-center mr-4"},je=["src"],Ee={class:"font-semibold"},$e={class:"text-[12px]"},De={key:1,class:"w-full box-border flex items-center justify-center h-full w-full"},Ie=e("p",{class:"text-center italic"},"Belum Ada materi",-1),Me=[Ie],Ae={class:"w-full lg:w-1/5 box-border mb-5 lg:mb-0"},Te={class:"w-full rounded box-border py-3 px-3 bg-white"},Be=e("div",{class:"mb-4 w-full flex items-center justify-between"},[e("h1",{class:"text-base text-[#222222] font-semibold"},"Kalender")],-1),Re=e("div",{class:"w-full flex items-center justify-center mb-5"},[e("div",{class:"bg-[#7F83FF]/70 text-white rounded-[8px] w-20 h-20 font-bold flex items-center justify-center text-[42px]"}," 12 ")],-1),Ne={class:"grid grid-cols-6 gap-3"},We={__name:"Home",setup(_){const x=localStorage.getItem("USERSISWA")?JSON.parse(localStorage.getItem("USERSISWA")):{},u=D(),y=I(),g=d([]),h=d([]),m=d([]),S=d(["bg-[#7F83FF]","bg-[#93E674]","bg-[#FF808B]","bg-[#FFA880]"]),k=d(["bg-[#FDD0D5]","bg-[#D0EAFB]","bg-[#D0FCEB]","bg-[#FEFDD1]"]),F=()=>{y.isRunningTest==1?u.push({path:"/tes"}):(j(),E())},j=async()=>{try{const{data:a}=await instanceSiswa({url:"peserta/dashboard/popular-materi",method:"GET"}),r=a.data;h.value=r.slice(0,4);const t=r.sort((i,p)=>p.jumlah_dibaca-i.jumlah_dibaca);g.value=t.slice(0,4)}catch(a){a.response.status==401&&(localStorage.removeItem("TOKENSISWA"),localStorage.removeItem("USERSISWA"),location.reload())}},E=async()=>{try{const{data:a}=await instanceSiswa({url:"peserta/dashboard/nilai-tertinggi",method:"GET"});m.value=a.data}catch(a){a.response.status==401&&(localStorage.removeItem("TOKENSISWA"),localStorage.removeItem("USERSISWA"),location.reload())}},$=(a="",r=0)=>a.substring(0,r);return M(()=>{F()}),(a,r)=>(s(),o("div",Q,[e("div",X,[e("div",Y,[A(q,{user:n(x)},null,8,["user"])]),e("div",Z,[e("div",ee,[(s(!0),o(c,null,b(g.value,(t,i)=>(s(),o("div",{key:i,class:w(["w-full h-[150px] rounded-[20px] box-border p-4",S.value[i]])},[e("div",te,[e("img",{src:n(B),alt:"",class:"w-6"},null,8,se)]),e("div",oe,l($(t.judul,18)),1),e("div",le,l(t.jumlah_dibaca)+" Kali Dibaca",1)],2))),128))])])]),e("div",ae,[e("div",ie,[re,e("div",ne,[e("table",de,[ce,m.value.length!=0?(s(),o("tbody",ue,[(s(!0),o(c,null,b(m.value,(t,i)=>(s(),o("tr",{key:i},[e("td",be,[e("div",_e,l(i+1),1)]),e("td",he,[e("div",null,l(t.siswa.nama),1),e("div",me,l(t.siswa.nik??"-"),1)]),e("td",xe,l(t.total),1)]))),128))])):(s(),o("tbody",ge,fe))])])]),e("div",we,[e("div",ve,[ye,e("button",{onClick:r[0]||(r[0]=f(t=>n(u).push({name:"siswaMateri"}),["prevent"])),class:"text-gray-600 bg-gray-100 rounded px-3 py-1 text-xs hover:text-white hover:bg-green-400"},"View All")]),h.value.length!=0?(s(),o("div",Se,[(s(!0),o(c,null,b(h.value,(t,i)=>(s(),o("div",{key:i,onClick:f(p=>n(u).push({name:"siswaDetailMateri",params:{id:t.id}}),["prevent"]),class:w(["cursor-pointer w-full rounded mb-3 p-3 flex",k.value[i]])},[e("div",Fe,[e("img",{src:n(T),alt:"",class:"w-12"},null,8,je)]),e("div",null,[e("p",Ee,l(t.judul),1),e("p",$e,l(t.excerpt),1)])],10,ke))),128))])):(s(),o("div",De,Me))]),e("div",Ae,[e("div",Te,[Be,Re,e("div",Ne,[(s(),o(c,null,b(6,t=>e("div",{key:t,class:"bg-[#7F83FF]/20 h-6 w-6 flex items-center justify-center font-bold"},l(t),1)),64))])])])])]))}};export{We as default};
