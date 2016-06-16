<?php
/*
 * This file is part of the dzer/express.
 *
 * (c) dzer <d20053140@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/**
 * Express
 *
 * @author    dzer <d20053140@gmail.com>
 * @copyright 2016 dzer <d20053140@gmail.com>
 *
 * @link      https://github.com/dzer
 * @link      http://dzer.me
 */

namespace dzer\express;

use Yii;

class Express extends \yii\base\Component
{
    /**
     * 快递100查询地址
     *
     * @var string
     */
    static $url = 'http://wap.kuaidi100.com/wap_result.jsp?&fromWeb=null&';

    /**
     * 物流编码
     * 支持以下物流查询
     *
     * @var array
     */
    static $data = array(
        'shunfeng' => '顺丰',
        'yuantong' => '圆通速递',
        'shentong' => '申通',
        'yunda' => '韵达快运',
        'ems' => 'ems快递',
        'tiantian' => '天天快递',
        'zhaijisong' => '宅急送',
        'quanfengkuaidi' => '全峰快递',
        'zhongtong' => '中通速递',
        'rufengda' => '如风达',
        'debangwuliu' => '德邦物流',
        'huitongkuaidi' => '汇通快运',
        'aae' => 'aae全球专递',
        'anjie' => '安捷快递',
        'anxindakuaixi' => '安信达快递',
        'biaojikuaidi' => '彪记快递',
        'bht' => 'bht',
        'baifudongfang' => '百福东方国际物流',
        'coe' => '中国东方（COE）',
        'changyuwuliu' => '长宇物流',
        'datianwuliu' => '大田物流',
        'dhl' => 'dhl',
        'dpex' => 'dpex',
        'dsukuaidi' => 'd速快递',
        'disifang' => '递四方',
        'fedex' => 'fedex（国外）',
        'feikangda' => '飞康达物流',
        'fenghuangkuaidi' => '凤凰快递',
        'feikuaida' => '飞快达',
        'guotongkuaidi' => '国通快递',
        'ganzhongnengda' => '港中能达物流',
        'guangdongyouzhengwuliu' => '广东邮政物流',
        'gongsuda' => '共速达',
        'hengluwuliu' => '恒路物流',
        'huaxialongwuliu' => '华夏龙物流',
        'haihongwangsong' => '海红',
        'haiwaihuanqiu' => '海外环球',
        'jiayiwuliu' => '佳怡物流',
        'jinguangsudikuaijian' => '京广速递',
        'jixianda' => '急先达',
        'jjwl' => '佳吉物流',
        'jymwl' => '加运美物流',
        'jindawuliu' => '金大物流',
        'jialidatong' => '嘉里大通',
        'jykd' => '晋越快递',
        'kuaijiesudi' => '快捷速递',
        'lianb' => '联邦快递（国内）',
        'lianhaowuliu' => '联昊通物流',
        'longbanwuliu' => '龙邦物流',
        'lijisong' => '立即送',
        'lejiedi' => '乐捷递',
        'minghangkuaidi' => '民航快递',
        'meiguokuaidi' => '美国快递',
        'menduimen' => '门对门',
        'ocs' => 'OCS',
        'peisihuoyunkuaidi' => '配思货运',
        'quanchenkuaidi' => '全晨快递',
        'quanjitong' => '全际通物流',
        'quanritongkuaidi' => '全日通快递',
        'quanyikuaidi' => '全一快递',
        'santaisudi' => '三态速递',
        'shenghuiwuliu' => '盛辉物流',
        'sue' => '速尔物流',
        'shengfeng' => '盛丰物流',
        'saiaodi' => '赛澳递',
        'tiandihuayu' => '天地华宇',
        'tnt' => 'tnt',
        'ups' => 'ups',
        'wanjiawuliu' => '万家物流',
        'wenjiesudi' => '文捷航空速递',
        'wuyuan' => '伍圆',
        'wxwl' => '万象物流',
        'xinbangwuliu' => '新邦物流',
        'xinfengwuliu' => '信丰物流',
        'yafengsudi' => '亚风速递',
        'yibangwuliu' => '一邦速递',
        'youshuwuliu' => '优速物流',
        'youzhengguonei' => '邮政包裹挂号信',
        'youzhengguoji' => '邮政国际包裹挂号信',
        'yuanchengwuliu' => '远成物流',
        'yuanweifeng' => '源伟丰快递',
        'yuanzhijiecheng' => '元智捷诚快递',
        'yuntongkuaidi' => '运通快递',
        'yuefengwuliu' => '越丰物流',
        'yad' => '源安达',
        'yinjiesudi' => '银捷速递',
        'zhongtiekuaiyun' => '中铁快运',
        'zhongyouwuliu' => '中邮物流',
        'zhongxinda' => '忠信达',
        'zhimakaimen' => '芝麻开门'
    );

    /**
     * 查询快递单号
     *
     * @param string $code 快递编码
     * @param string $number 快递单号
     * @param string $output 返回数据格式 默认返回数组，可返回json
     * @return array|bool|mixed|string
     */
    public static function search($code, $number, $output = '')
    {
        $data = array(
            'id' => trim($code),
            'postid' => trim($number),
            'rand' => rand(10000, 99999)
        );
        //拼接url
        self::$url = self::$url . http_build_query($data);
        //请求接口
        $result = self::httpGet(self::$url);
        if (!empty($result)) {
            $result = self::handleResult($result);
        } else {
            $result = array('status' => 0, 'message' => '请求错误', 'data' => array());;
        }
        return $output == 'json' ? json_encode($result)  : $result;
    }

    /**
     * 查询快递编码
     *
     * @param string $name 快递名称
     * @return bool|string
     */
    public static function getCode($name)
    {
        return array_search($name, self::$data);
    }

    /**
     * 返回所有的快递
     *
     * @return array
     */
    public static function getAll()
    {
        return self::$data;
    }

    /**
     * 正则处理查询结果
     *
     * @param string $result 请求的结果
     * @return bool|mixed
     */
    private static function handleResult($result)
    {
        $arr = array();
        preg_match_all('/<\/strong><\/p>(.+)<\/form>/s', $result, $content);
        if (isset($content[1][0]) && !empty($content[1][0])) {
            preg_match_all('/<p>&middot;(.{19})<br \/> (.+?)<\/p>/s', $content[1][0], $content);
            if (!empty($content[1]) && !empty($content[2])) {
                foreach ($content[1] as $k => $v) {
                    $arr[] = array(
                        'time' => $v,
                        'content' => isset($content[2][$k]) ? $content[2][$k] : ''
                    );
                }
            }
        }
        if (!empty($arr)) {
            return array('status' => 1, 'message' => '查询成功', 'data' => $arr);
        } else {
            return array('status' => 0, 'message' => '此单号暂无物流信息，请核对订单号码是否正确', 'data' => array());
        }
    }

    /**
     * curl请求
     *
     * @param string $url 请求连接
     * @return bool|mixed
     */
    private static function httpGet($url)
    {
        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 15);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }
}
