
class resizer {
    constructor(){
        this.initBind = this.init.bind(this);
        this.doDragBind = this.doDrag.bind(this);
        this.stopDragBind = this.stopDrag.bind(this);
        this.handles = [];
        this.handleRect = {};
        this.eleRect = {};

        this.ele = document.querySelector('p.ex');
        this.ele.addEventListener('click', this.initBind, false);
    }

    init(){
        this.ele.removeEventListener('click', this.initBind, false);
        this.ele.classList.add('resizable');
        if(this.handles.length == 0){
            this.eleRect = this.ele.getBoundingClientRect();    
            this.createHandle();
            this.createHandle();
            this.createHandle();
            this.createHandle();
            this.quitSelection();
        }
        this.rectStart();
    }

    quitSelection(){
        window.addEventListener('mousedown', (e) => {   
            if (!this.ele.contains(e.target)){
                this.ele.classList.remove('resizable');
                this.ele.addEventListener('click', this.initBind, false);
                this.handles.forEach((element) => {
                    element.setAttribute('style', 'display: none;');
                });
            }
        });
        window.addEventListener('keyup', (e) => {   
            if ((e.keyCode || e.which) == 27){
                console.log(e);
                this.ele.classList.remove('resizable');
                this.ele.addEventListener('click', this.initBind, false);
                this.handles.forEach((element) => {
                    element.setAttribute('style', 'display: none;');
                });
            }
        });
    }

    createHandle(){
        var resizer = document.createElement('div');
        resizer.classList.add('resizer');
        this.ele.appendChild(resizer);
        this.handleRect = resizer.getBoundingClientRect(); //TODO: move this
        resizer.addEventListener('mousedown', this.initDrag.bind(this), false);
        this.handles.push(resizer);
    }

    rectStart(){
  
        this.handlesPos = [`left:`+(-this.handleRect.width)+`px; bottom:`+(-this.handleRect.height)+`px; cursor:nesw-resize`, //BL
            `left:`+(-this.handleRect.width)+`px; top:`+(-this.handleRect.height)+`px; cursor:nwse-resize`, //TL
            `right:`+(-this.handleRect.width)+`px; top:`+(-this.handleRect.height)+`px; cursor:nesw-resize`, //TR
            `right:`+(-this.handleRect.width)+`px; bottom:`+(-this.handleRect.height)+`px; cursor:nwse-resize` //BR
        ];

        this.handlesPos.forEach(function (data, idx){
            this.handles[idx].setAttribute('style', data);
        }, this);
    }

    initDrag(e) {
        this.handle = e.target;
        this.startX = e.clientX;
        this.startY = e.clientY;
        this.eleRect = this.ele.getBoundingClientRect();
        document.documentElement.addEventListener('mousemove', this.doDragBind, false);
        document.documentElement.addEventListener('mouseup', this.stopDragBind, false);
    }

    doDrag(e) {
        var dX = e.clientX - this.startX;
        var dY = e.clientY - this.startY;

        switch (this.handle){
            case this.handles[0]:
            this.ele.style.width = Math.round(this.eleRect.width - dX) + 'px';
            this.ele.style.height = Math.round(this.eleRect.height + dY) + 'px';
            break;
            case this.handles[1]:
            this.ele.style.width = Math.round(this.eleRect.width - dX) + 'px';
            this.ele.style.height = Math.round(this.eleRect.height - dY) + 'px';
            break;
            case this.handles[2]:
            this.ele.style.width = Math.round(this.eleRect.width + dX) + 'px';
            this.ele.style.height = Math.round(this.eleRect.height - dY) + 'px';
            break;
            case this.handles[3]:
            this.ele.style.width = Math.round(this.eleRect.width + dX) + 'px';
            this.ele.style.height = Math.round(this.eleRect.height + dY) + 'px';
            break;
        }
    }
    
    stopDrag(e) {
        document.documentElement.removeEventListener('mousemove', this.doDragBind, false);    
        document.documentElement.removeEventListener('mouseup', this.stopDragBind, false);
        
    }
}
export default resizer;

