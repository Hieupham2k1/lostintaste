<template>
    <div :key="clearGameKey">
        <div class="fixed-top"><h3>Time: {{ timer }}s<span v-if="mode == 3"> | Moves: {{ moveCount > 0 ? moveCount : 0 }}</span></h3></div>
        <table>
            <tbody>
                <tr>
                    <td>Width:</td>
                    <td><input v-model="width" :disabled="isStart" class="form-control" /></td>
                </tr>
                <tr>
                    <td>Mode:</td>
                    <td>
                        <select v-model="mode" :disabled="isStart" class="custom-select">
                            <option v-for="(gameMode, value) in gameModes" :key="value" :value="value">{{ gameMode.label }}</option>
                        </select>
                    </td>
                </tr>
                <tr><button @click="start()" class="btn btn-primary my-3">{{ isStart ? 'Clear' : 'Start' }}</button></tr>
            </tbody>
        </table>
        <div class="overflow-auto row">
            <div class="col"></div>
            <div>
                <div class="row" v-for="h in (width <= 0 || isNaN(width) ? 0 : width >= 50 ? 50 : parseInt(width))" :key="h">
                    <Cell 
                        v-for="w in (width <= 0 || isNaN(width) ? 0 : width >= 50 ? 50 : parseInt(width))" :key="w" 
                        :position="[h, w]"
                        :ref="'cell-' + h + '-' + w"
                        @changeFlow="changeFlow"
                        @chosen="cellChosen"
                    />
                </div>
            </div>
            <div class="col"></div>
        </div>
    </div>
</template>

<script>
import Cell from './Cell.vue'
export default {
    components:{
        Cell,
    },
    data(){
        return {
            width: 10,
            chosenCellPosition: [],
            mode: 0,
            isStart: false,
            timer: 0,
            moveCount: 0,
            clearGameKey: 0,
            gameModes: [
                {
                    'funcName': 'quickFitMode',
                    'label': 'Quick fit',
                    'variables':{
                        'condition': () => this.timer == 0,
                        'message': () => this.countFlowedCells() + 'heart cells',
                        'increment': -1,
                    },
                },
                {
                    'funcName': 'match2HeartsMode',
                    'label': 'Match 2 hearts',
                    'variables':{
                        'condition': () => this.$refs[`cell-${ this.width }-${ this.width }`]?.[0].flow.includes(1),
                        'message': () => `in ${ this.timer } seconds`,
                        'increment': 1,
                    },
                },
                {
                    'funcName': 'unmovableMode',
                    'label': 'Unmovable',
                    'variables':{
                        'condition': () => this.$refs[`cell-${ this.width }-${ this.width }`]?.[0].flow.includes(1),
                        'message': () => `in ${ this.timer } seconds`,
                        'increment': 1,
                    },
                },
                {
                    'funcName': 'limitedMovesMode',
                    'label': 'Limited Moves',
                    'variables':{
                        'condition': () => this.moveCount == 0 || this.$refs[`cell-${ this.width }-${ this.width }`]?.[0].flow.includes(1),
                        'message': () => this.moveCount != 0 ? `in ${ this.timer } seconds` : 'fail with given moves',
                        'increment': 1,
                    },
                },
            ],
        }
    },
    methods:{
        changeFlow(position){
            let refNames = [
                `cell-${ position[0] - 1 }-${ position[1] }`,
                `cell-${ position[0] }-${ position[1] + 1 }`,
                `cell-${ position[0] + 1 }-${ position[1] }`,
                `cell-${ position[0] }-${ position[1] - 1 }`,
            ];

            let currentCell = this.$refs[`cell-${ position[0] }-${ position[1] }`]?.[0];

            if(this.chosenCellPosition.length != 0) this.setChosenCellPosition([]); // if changing flow then non is chosen

            for(let i in refNames){ // update current cell
                let neighborCell = this.$refs[refNames[i]]?.[0];
                if(!neighborCell) continue;

                let int = parseInt(i);
                let opositeSide = (int >= 2) ? int - 2 : int + 2;

                currentCell.flow[i] = (
                    neighborCell.flow.includes(1) & // if neighbor cell has flow
                    neighborCell.flow[opositeSide] != 1 & // but not from current cell
                    neighborCell.open[opositeSide] & currentCell.open[i] // and neighbor cell conects with current cell
                ); // then current cell has flow, else not
            }
            for(let i in refNames){ // update neighbor cells
                let neighborCell = this.$refs[refNames[i]]?.[0];
                if(!neighborCell) continue;

                let int = parseInt(i);
                let opositeSide = (int >= 2) ? int - 2 : int + 2;

                let neighborHadFlow = neighborCell.flow.includes(1);

                neighborCell.flow[opositeSide] = ( // similar as above
                    currentCell.flow.includes(1) & 
                    currentCell.flow[i] != 1 & 
                    currentCell.open[i] & neighborCell.open[opositeSide]
                );
                neighborCell.$forceUpdate();

                if(neighborHadFlow != neighborCell.flow.includes(1)){ // if neighbor cell change state of hasFlow
                    neighborCell.emitChangeFlow();
                }
            }
        },
        cellChosen(position){
            if(this.isUnmovable(position) || this.mode == 2) return; // might have bugs
            let chosenCell = this.$refs[`cell-${ this.chosenCellPosition[0] }-${ this.chosenCellPosition[1] }`]?.[0];
            let targetCell = this.$refs[`cell-${ position[0] }-${ position[1] }`]?.[0];
            if(this.chosenCellPosition.length == 0){
                this.setChosenCellPosition(position);
                return;
            }

            let heightDiff = Math.abs(this.chosenCellPosition[0] - position[0]);
            let widthDiff  = Math.abs(this.chosenCellPosition[1] - position[1]);
            
            this.setChosenCellPosition([]); // this code must be here to preserve this.chosenCellPosition for heightDiff and widthDiff

            if( // if target cell is out of reach or is current cell, do nothing
                heightDiff > 1 || 
                widthDiff > 1  ||
                heightDiff == widthDiff
            ){
                return;
            }

            let temp = [...chosenCell.open];
            chosenCell.open = [...targetCell.open];
            targetCell.open = [...temp];
            this.moveCount--;

            chosenCell.emitChangeFlow();
            targetCell.emitChangeFlow();
        },
        isUnmovable(position){
            return position[0] == position[1] && (position[0] == 1 || position[0] == this.width);
        },
        setChosenCellPosition(position){
            let chosenCell = this.$refs[`cell-${ this.chosenCellPosition[0] }-${ this.chosenCellPosition[1] }`]?.[0];
            if(chosenCell) chosenCell.isChosen = position.length != 0;
            this.chosenCellPosition = [...position];
            chosenCell = this.$refs[`cell-${ this.chosenCellPosition[0] }-${ this.chosenCellPosition[1] }`]?.[0];
            if(chosenCell) chosenCell.isChosen = position.length != 0;
        },
        start(){
            this.clearGameKey++;
            this.isStart = !this.isStart;
            if(!this.isStart) return;
            setTimeout(()=>{ this[this.gameModes[this.mode].funcName](); }, 0); // must setTimeout for unmovable mode to rerender
        },
        quickFitMode(){
            this.timer = 30;
            this.setTimer();
        },
        match2HeartsMode(){
            this.timer = 0;
            this.setTimer();
        },
        unmovableMode(){
            for(let h = 1; h <= this.width; h++){
                for(let w = 1; w <= this.width; w++){
                    if(this.isUnmovable([h, w])) continue;
                    this.$refs[`cell-${ h }-${ w }`]?.[0].setOpenRandomly(2);
                    this.$refs[`cell-${ h }-${ w }`]?.[0].emitChangeFlow();
                }
            }
            this.match2HeartsMode();
        },
        limitedMovesMode(){
            this.moveCount = 30;
            this.setTimer();
        },
        countFlowedCells(){
            let count = 0;
            for(let h = 1; h <= this.width; h++){
                for(let w = 1; w <= this.width; w++){
                    if(this.$refs[`cell-${ h }-${ w }`]?.[0].flow.includes(1)) count++;
                }
            }
            return count;
        },
        setTimer(){
            let interval = setInterval(() => {
                let modeVar = this.gameModes[this.mode].variables;
                this.timer += modeVar.increment;

                if(modeVar.condition() || !this.isStart){
                    clearInterval(interval);
                    if(!this.isStart){
                        this.timer = 0;
                        return;
                    }
                    this.isStart = false;
                    if(!confirm(`You have matched ${ modeVar.message() }! Want to see your work?`)) this.clearGameKey++;
                }
            }, 1000);
        }
    },
    mounted(){
        this.$refs['cell-1-2'][0].emitChangeFlow();
        this.$refs['cell-1-2'][0].$forceUpdate();
    }
}
</script>

<style>
    .fixed-top{
        left: 40%;
        right: auto;
        background: #f3bdbd;
    }
</style>