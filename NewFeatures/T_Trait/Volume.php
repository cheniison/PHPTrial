<?php
/**
 * @file Volume.php
 * @brief 音量性状
 * @author cheniison
 * @version 1.0
 * @date 2017-06-27
 */

namespace PHPTrial\NewFeatures\T_Trait;


/**
 * @brief 音量性状定义
 */
trait Volume{

    protected $vol;    //音量大小
    
    public function getVol():int
    {
        return $this->vol;
    }

    public function setVol(int $v):int
    {
        $this->vol = $this->controlVol($v);
        return $this->vol;
    }


    /**
     * @brief 调高音量
     *
     * @param v 需要调高多少
     *
     * @return 最后的音量值
     */
    public function turnupVol(int $v):int
    {
        $this->vol += $v;
        $this->vol = $this->controlVol($this->vol);
        return $this->vol;
    }

    
    /**
     * @brief 控制音量在一定范围内
     *
     * @param int $v 音量
     *
     * @return 调整后的音量
     */
    private function controlVol(int $v):int
    {
        if($v > 100){
            // too high
            $v = 100;
        }elseif($v < 0){
            // too low
            $v = 0;
        }
        return $v;
    }
}


