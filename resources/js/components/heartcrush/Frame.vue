<template>
    <div class="overflow-auto row">
        <div class="col"></div>
        <div>
            <div class="row" v-for="h in width" :key="h">
                <Cell 
                    v-for="w in width" :key="w" 
                    :position="[h, w]"
                    :ref="'cell-' + h + '-' + w"
                    @changeFlow="changeFlow"
                    @chosen="cellChosen"
                />
            </div>
        </div>
        <div class="col"></div>
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
            if(this.isUnmovable(position)) return;
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
        }
    },
    created(){
        
    },
    mounted(){
        this.$refs['cell-1-2'][0].emitChangeFlow();
        this.$refs['cell-1-2'][0].$forceUpdate();
    }
}
</script>

<style>

</style>