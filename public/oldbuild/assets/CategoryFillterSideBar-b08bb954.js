import{r as o,j as e}from"./app-aef64c69.js";function f({handleCheckboxChange:n,filters:i,maxRange:d,getPercentage:t,attributes:m,subCtg:h,maxPrice:g}){const[l,_]=o.useState(!0),[r,p]=o.useState(!0),[c,u]=o.useState({}),x=s=>{u(a=>({...a,[s]:!a[s]}))},w=()=>{_(!l),n()},b=()=>{p(!r)};return e.jsxs(e.Fragment,{children:[e.jsxs("div",{className:"mainSidebar",children:[h.length>0&&e.jsxs("div",{className:"single__widget widget__bg",children:[e.jsx("h2",{className:"widget__title h3",children:e.jsxs("label",{className:"widget__categories--menu__label d-flex align-items-center",onClick:w,style:{cursor:"pointer"},children:[e.jsx("span",{className:"widget__categories--menu__text",children:"Categories"}),e.jsx("svg",{className:`widget__categories--menu__arrowdown--icon ${l?"rotate-icon":""}`,xmlns:"http://www.w3.org/2000/svg",width:"12.355",height:"8.394",children:e.jsx("path",{d:"M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z",transform:"translate(-6 -8.59)",fill:"currentColor"})})]})}),e.jsx("ul",{className:"widget__categories--menu",children:e.jsx("li",{className:"",children:l&&e.jsx("ul",{className:`widget__categories--sub__menu ${l?"open":""}`,children:h.map(s=>e.jsxs("li",{className:"widget__categories--sub__menu--list fabric",children:[e.jsx("label",{className:"widget__form--check__label",for:`flexCheckDefault${s.id}`,children:s.name}),e.jsx("div",{className:"form-check",children:e.jsx("input",{className:"form-check-input",type:"checkbox",name:"category",value:s.id,id:`flexCheckDefault${s.id}`,onChange:n,checked:i.category.includes(s.id.toString())})})]},s.id))})})})]}),m.length>0&&m.map(s=>e.jsxs("div",{className:"single__widget widget__bg",children:[e.jsx("h2",{className:"widget__title h3",children:e.jsxs("label",{className:"widget__categories--menu__label d-flex align-items-center",onClick:()=>x(s.id),style:{cursor:"pointer"},children:[e.jsx("span",{className:"widget__categories--menu__text",children:s.name}),e.jsx("svg",{className:`widget__categories--menu__arrowdown--icon ${c[s.id]?"rotate-icon":""}`,xmlns:"http://www.w3.org/2000/svg",width:"12.355",height:"8.394",children:e.jsx("path",{d:"M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z",transform:"translate(-6 -8.59)",fill:"currentColor"})})]})}),e.jsx("ul",{className:"widget__categories--menu",children:e.jsx("li",{children:c[s.id]&&e.jsx("ul",{className:`widget__categories--sub__menu ${c[s.id]?"open":""}`,children:s.subAttr.map(a=>e.jsx("li",{className:"widget__categories--sub__menu--list fabric",children:e.jsxs("div",{className:"form-check",children:[e.jsx("input",{className:"form-check-input",type:"checkbox",name:"fabric",value:a.id,id:`flexCheckDefault-${a.id}-1`,onChange:n,checked:i.fabric.includes(a.id.toString())}),e.jsx("label",{className:"form-check-label",htmlFor:`flexCheckDefault-${a.id}-1`,children:a.name})]})}))})})})]},s.id)),g>0&&e.jsxs("div",{className:"single__widget price__filter widget__bg",children:[e.jsx("h2",{className:"widget__title h3",children:e.jsxs("label",{className:"widget__categories--menu__label d-flex align-items-center",onClick:b,style:{cursor:"pointer"},children:[e.jsx("span",{className:"widget__categories--menu__text",children:"Filter By Price"}),e.jsx("svg",{className:`widget__categories--menu__arrowdown--icon ${r?"rotate-icon":""}`,xmlns:"http://www.w3.org/2000/svg",width:"12.355",height:"8.394",children:e.jsx("path",{d:"M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z",transform:"translate(-6 -8.59)",fill:"currentColor"})})]})}),r&&e.jsx("form",{className:`price__filter--form ${r?"open":""}`,action:"#",children:e.jsxs("div",{className:"slider-container",children:[e.jsxs("div",{className:"range-values",children:[e.jsxs("span",{children:["BDT : ",i.min_price," "]}),e.jsxs("span",{children:["BDT : ",i.max_price," "]})]}),e.jsxs("div",{className:"slider-track",children:[e.jsx("input",{type:"range",name:"min_price",value:i.min_price,min:"0",max:d,onChange:n,className:"thumb thumb-left"}),e.jsx("input",{type:"range",name:"max_price",value:i.max_price,min:"0",max:d,onChange:n,className:"thumb thumb-right"}),e.jsx("div",{className:"range-highlight",style:{left:`${t(i.min_price)}%`,width:`${t(i.max_price)-t(i.min_price)}%`}})]})]})})]})]}),e.jsx("style",{children:`
    .slider-container {
    margin: 20px auto;
    position: relative;
  }
  
  .range-values {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }
  
  .slider-track {
    position: relative;
    height: 6px;
    background: #ddd;
    border-radius: 3px;
  }
  
  .thumb {
    position: absolute;
    width: 100%;
    pointer-events: none;
    -webkit-appearance: none;
    appearance: none;
    background: transparent;
  }
  
  .thumb::-webkit-slider-thumb {
    pointer-events: all;
    width: 16px;
    height: 16px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
    -webkit-appearance: none;
    appearance: none;
  }
  
  .thumb::-moz-range-thumb {
    pointer-events: all;
    width: 16px;
    height: 16px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
  }
  
  .range-highlight {
    position: absolute;
    top: 0;
    height: 100%;
    background: #007bff;
    border-radius: 3px;
    z-index: 1;
  }
    .range-values span {
    background-color: #0092d7;
    color: #fff;
    padding: 1px 10px;
    font-size: 14px;
    font-weight: bold;
    border-radius: 3px;
    margin-bottom: 10px;
    }

    `})]})}export{f as C};
