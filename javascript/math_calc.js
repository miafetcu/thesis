//math calculation
document.addEventListener('DOMContentLoaded', () => {
    const queryParams = new URLSearchParams(window.location.search);
    const data = Object.fromEntries(queryParams.entries());
    displayObject(data);

});
function displayObject(data) {
    console.log(data)
const energy_space = document.getElementById('energy');
const min_panels_space = document.getElementById('min_panels');
const max_panels_space = document.getElementById('max_panels');
const sav_space = document.getElementById('sav');
const invest_space = document.getElementById('invest');
// const invest_space2 = document.getElementById('invest1');
// const panels_space2 = document.getElementById('panels2');

const solarCapacityFactor = 0.2;

const Solar_Hours = [4, 4.5, 5];
// const Behaviour = [1.2, 1.1, 1];
if (data.monthly_cons >= 800 ) {
    behaviour = 1.25;
} else if (data.monthly_cons >=600 && data.monthly_cons<800) {
   behaviour = 1.2;
} else if (data.monthly_cons >=300 && data.monthly_cons<600){
    behaviour = 1.1; 
}else{
    behaviour = 1;
}
console.log(behaviour);
const energy_panel = 500;

const reg_North = ["briceni","ocnita","edinet","riscani","donduseni","soroca","drochia","glodeni","falesti","sangerei","balti","floresti"];
const reg_Center = ["soldanesti","rezina","telenesti","ungheni","calarasi","nisporeni","orhei","straseni","hancesti","ialoveni","chisinau","anenii noi","criuleni","dubasari"];
const reg_Sud = ["leova","cimislia","causeni","stefan voda","comrat","cantemir","cahul","taraclia"]

console.log(data.init);
dataInit = data.init.toLowerCase();
console.log(data.init);

let min_panels_math = 0;
let consumation= data.monthly_cons*12;

min_panels_math = consumation * behaviour/energy_panel;

min_panels_math = Math.ceil(min_panels_math);

const area_panel = 2.1;
let energy_math = 0;
if (reg_North.some(region => dataInit.includes(region)) ) {
    energy_math =  min_panels_math*area_panel * solarCapacityFactor * Solar_Hours[0] * 365;
} else if (reg_Center.some(region => dataInit.includes(region)) ){
    energy_math = min_panels_math*area_panel * solarCapacityFactor * Solar_Hours[1] * 365;
} else if (reg_Sud.some(region => dataInit.includes(region)) ){ 
    energy_math = min_panels_math*area_panel* solarCapacityFactor * Solar_Hours[2] * 365;
} else {
    energy_math = min_panels_math*area_panel * solarCapacityFactor * Solar_Hours[1] * 365;
}
energy_math = Math.ceil(energy_math);
console.log(energy_math);
max_panels_math = data.capcValue/area_panel;
max_panels_math = Math.ceil(max_panels_math)

const price_kwh = data.price;
const euroConvert = 19;
let savings_math = energy_math*price_kwh/euroConvert;
savings_math = Math.ceil(savings_math);

const price_panel =400;

let invest_math = min_panels_math*price_panel;
console.log(min_panels_math);
console.log(invest_math);
energy_space.innerHTML = `${energy_math}`;
min_panels_space.innerHTML = `${min_panels_math}`;
max_panels_space.innerHTML = `${max_panels_math}`;
sav_space.innerHTML = `${savings_math}`;
invest_space.innerHTML = `${invest_math}`;
// invest_space2.innerHTML = `${"mia"}`;
// panels_space2.innerHTML = `${max_panels_math}`;

}