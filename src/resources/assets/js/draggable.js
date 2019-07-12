class draggable{
    constructor(){
        this.doDragBind = this.doDrag.bind(this);
        this.stopDragBind = this.stopDrag.bind(this);
        this.initDragBind = this.initDrag.bind(this);
        this.objHandle = document.getElementById('dragging');
        if(this.objHandle.closest(".draggable")){
            this.objHandle = this.objHandle.parentElement;
        }
        this.lastPosX = this.objHandle.getBoundingClientRect().left;
        this.lastPosY = this.objHandle.getBoundingClientRect().top;
        this.objHandle.addEventListener('mousedown', this.initDragBind ,false);
    }

    initDrag(e){
        this.objHandle.removeEventListener('mousedown', this.initDragBind, false);
        this.eleDrag = e.target;
        this.startX = e.clientX;
        this.startY = e.clientY;
        console.log('begin:',this.startX);
        document.documentElement.addEventListener('mousemove', this.doDragBind, false);
        document.documentElement.addEventListener('mouseup', this.stopDragBind, false);
    }

    doDrag(e){
        Math.round()
        this.newPosX = Math.round(e.clientX - this.startX + this.lastPosX);
        this.newPosY = Math.round(e.clientY - this.startY + this.lastPosY); 
        this.objHandle.setAttribute('style','position:absolute; left:'+(this.newPosX) + 'px; top:'+(this.newPosY) + 'px;');
    }

    stopDrag(e) {
        this.lastPosX = this.newPosX;
        this.lastPosY = this.newPosY;
        document.documentElement.removeEventListener('mousemove', this.doDragBind, false);    
        document.documentElement.removeEventListener('mouseup', this.stopDragBind, false);
        this.objHandle.addEventListener('mousedown', this.initDragBind ,false);
    }
}
export default draggable;