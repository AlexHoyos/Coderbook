function getTimeStr(time){
    if(time < 60){
        return time + 's'
    } else {

        time = Math.floor(time/60)
        if(time < 60){
            return time + ' min'
        } else {
            time = Math.floor(time/60)
            
            if(time < 24){
                return time + ' hr'
            } else {
                time = Math.floor(time/24)
                if(time < 7){

                    return time + ' d'

                } else {
                    time = Math.floor(time/7)
                    if(time < 4){
                        return time + ' sem'
                    } else {
                        time = time * 7
                        if(time >= 365){
                            time = Math.floor(time/365.25)
                            if(time == 1){
                                return time + ' año'
                            } else {
                                return time + ' años'
                            }
                            
                        } else {
                            console.log(time)
                            time = Math.ceil(time/30)
                            return time + ' m'
                        }
                    }
                }
            }

        }

    }
}