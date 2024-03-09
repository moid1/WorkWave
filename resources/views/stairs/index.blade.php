@extends('layouts.app')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<style>
    .side-menu {
        display: none;
    }

    .content-page {
        margin-left: 0px !important;
    }
</style>
@section('content')
    <div class="row">

        <div class="col-lg-3">

            <div class="form-group">
                <label>Floor Height</label>
                <select class="form-control" id="FloorHeight">
                    <option value="300">300mm</option>
                    <option value="305">305mm</option>
                    <option value="310">310mm</option>
                    <option value="315">315mm</option>
                    <option value="320">320mm</option>
                    <option value="325">325mm</option>
                    <option value="330">330mm</option>
                    <option value="335">335mm</option>
                    <option value="340">340mm</option>
                    <option value="345">345mm</option>
                    <option value="350">350mm</option>
                    <option value="355">355mm</option>
                    <option value="360">360mm</option>
                    <option value="365">365mm</option>
                    <option value="370">370mm</option>
                    <option value="375">375mm</option>
                    <option value="380">380mm</option>
                    <option value="385">385mm</option>
                    <option value="390">390mm</option>
                    <option value="395">395mm</option>
                    <option value="400">400mm</option>
                    <option value="405">405mm</option>
                    <option value="410">410mm</option>
                    <option value="415">415mm</option>
                    <option value="420">420mm</option>
                    <option value="425">425mm</option>
                    <option value="430">430mm</option>
                    <option value="435">435mm</option>
                    <option value="440">440mm</option>
                    <option value="445">445mm</option>
                    <option value="450">450mm</option>
                    <option value="455">455mm</option>
                    <option value="460">460mm</option>
                    <option value="465">465mm</option>
                    <option value="470">470mm</option>
                    <option value="475">475mm</option>
                    <option value="480">480mm</option>
                    <option value="485">485mm</option>
                    <option value="490">490mm</option>
                    <option value="495">495mm</option>
                    <option value="500">500mm</option>
                    <option value="505">505mm</option>
                    <option value="510">510mm</option>
                    <option value="515">515mm</option>
                    <option value="520">520mm</option>
                    <option value="525">525mm</option>
                    <option value="530">530mm</option>
                    <option value="535">535mm</option>
                    <option value="540">540mm</option>
                    <option value="545">545mm</option>
                    <option value="550">550mm</option>
                    <option value="555">555mm</option>
                    <option value="560">560mm</option>
                    <option value="565">565mm</option>
                    <option value="570">570mm</option>
                    <option value="575">575mm</option>
                    <option value="580">580mm</option>
                    <option value="585">585mm</option>
                    <option value="590">590mm</option>
                    <option value="595">595mm</option>
                    <option value="600">600mm</option>
                    <option value="605">605mm</option>
                    <option value="610">610mm</option>
                    <option value="615">615mm</option>
                    <option value="620">620mm</option>
                    <option value="625">625mm</option>
                    <option value="630">630mm</option>
                    <option value="635">635mm</option>
                    <option value="640">640mm</option>
                    <option value="645">645mm</option>
                    <option value="650">650mm</option>
                    <option value="655">655mm</option>
                    <option value="660">660mm</option>
                    <option value="665">665mm</option>
                    <option value="670">670mm</option>
                    <option value="675">675mm</option>
                    <option value="680">680mm</option>
                    <option value="685">685mm</option>
                    <option value="690">690mm</option>
                    <option value="695">695mm</option>
                    <option value="700">700mm</option>
                    <option value="705">705mm</option>
                    <option value="710">710mm</option>
                    <option value="715">715mm</option>
                    <option value="720">720mm</option>
                    <option value="725">725mm</option>
                    <option value="730">730mm</option>
                    <option value="735">735mm</option>
                    <option value="740">740mm</option>
                    <option value="745">745mm</option>
                    <option value="750">750mm</option>
                    <option value="755">755mm</option>
                    <option value="760">760mm</option>
                    <option value="765">765mm</option>
                    <option value="770">770mm</option>
                    <option value="775">775mm</option>
                    <option value="780">780mm</option>
                    <option value="785">785mm</option>
                    <option value="790">790mm</option>
                    <option value="795">795mm</option>
                    <option value="800">800mm</option>
                    <option value="805">805mm</option>
                    <option value="810">810mm</option>
                    <option value="815">815mm</option>
                    <option value="820">820mm</option>
                    <option value="825">825mm</option>
                    <option value="830">830mm</option>
                    <option value="835">835mm</option>
                    <option value="840">840mm</option>
                    <option value="845">845mm</option>
                    <option value="850">850mm</option>
                    <option value="855">855mm</option>
                    <option value="860">860mm</option>
                    <option value="865">865mm</option>
                    <option value="870">870mm</option>
                    <option value="875">875mm</option>
                    <option value="880">880mm</option>
                    <option value="885">885mm</option>
                    <option value="890">890mm</option>
                    <option value="895">895mm</option>
                    <option value="900">900mm</option>
                    <option value="905">905mm</option>
                    <option value="910">910mm</option>
                    <option value="915">915mm</option>
                    <option value="920">920mm</option>
                    <option value="925">925mm</option>
                    <option value="930">930mm</option>
                    <option value="935">935mm</option>
                    <option value="940">940mm</option>
                    <option value="945">945mm</option>
                    <option value="950">950mm</option>
                    <option value="955">955mm</option>
                    <option value="960">960mm</option>
                    <option value="965">965mm</option>
                    <option value="970">970mm</option>
                    <option value="975">975mm</option>
                    <option value="980">980mm</option>
                    <option value="985">985mm</option>
                    <option value="990">990mm</option>
                    <option value="995">995mm</option>
                    <option value="1000">1000mm</option>
                    <option value="1005">1005mm</option>
                    <option value="1010">1010mm</option>
                    <option value="1015">1015mm</option>
                    <option value="1020">1020mm</option>
                    <option value="1025">1025mm</option>
                    <option value="1030">1030mm</option>
                    <option value="1035">1035mm</option>
                    <option value="1040">1040mm</option>
                    <option value="1045">1045mm</option>
                    <option value="1050">1050mm</option>
                    <option value="1055">1055mm</option>
                    <option value="1060">1060mm</option>
                    <option value="1065">1065mm</option>
                    <option value="1070">1070mm</option>
                    <option value="1075">1075mm</option>
                    <option value="1080">1080mm</option>
                    <option value="1085">1085mm</option>
                    <option value="1090">1090mm</option>
                    <option value="1095">1095mm</option>
                    <option value="1100">1100mm</option>
                    <option value="1105">1105mm</option>
                    <option value="1110">1110mm</option>
                    <option value="1115">1115mm</option>
                    <option value="1120">1120mm</option>
                    <option value="1125">1125mm</option>
                    <option value="1130">1130mm</option>
                    <option value="1135">1135mm</option>
                    <option value="1140">1140mm</option>
                    <option value="1145">1145mm</option>
                    <option value="1150">1150mm</option>
                    <option value="1155">1155mm</option>
                    <option value="1160">1160mm</option>
                    <option value="1165">1165mm</option>
                    <option value="1170">1170mm</option>
                    <option value="1175">1175mm</option>
                    <option value="1180">1180mm</option>
                    <option value="1185">1185mm</option>
                    <option value="1190">1190mm</option>
                    <option value="1195">1195mm</option>
                    <option value="1200">1200mm</option>
                    <option value="1205">1205mm</option>
                    <option value="1210">1210mm</option>
                    <option value="1215">1215mm</option>
                    <option value="1220">1220mm</option>
                    <option value="1225">1225mm</option>
                    <option value="1230">1230mm</option>
                    <option value="1235">1235mm</option>
                    <option value="1240">1240mm</option>
                    <option value="1245">1245mm</option>
                    <option value="1250">1250mm</option>
                    <option value="1255">1255mm</option>
                    <option value="1260">1260mm</option>
                    <option value="1265">1265mm</option>
                    <option value="1270">1270mm</option>
                    <option value="1275">1275mm</option>
                    <option value="1280">1280mm</option>
                    <option value="1285">1285mm</option>
                    <option value="1290">1290mm</option>
                    <option value="1295">1295mm</option>
                    <option value="1300">1300mm</option>
                    <option value="1305">1305mm</option>
                    <option value="1310">1310mm</option>
                    <option value="1315">1315mm</option>
                    <option value="1320">1320mm</option>
                    <option value="1325">1325mm</option>
                    <option value="1330">1330mm</option>
                    <option value="1335">1335mm</option>
                    <option value="1340">1340mm</option>
                    <option value="1345">1345mm</option>
                    <option value="1350">1350mm</option>
                    <option value="1355">1355mm</option>
                    <option value="1360">1360mm</option>
                    <option value="1365">1365mm</option>
                    <option value="1370">1370mm</option>
                    <option value="1375">1375mm</option>
                    <option value="1380">1380mm</option>
                    <option value="1385">1385mm</option>
                    <option value="1390">1390mm</option>
                    <option value="1395">1395mm</option>
                    <option value="1400">1400mm</option>
                    <option value="1405">1405mm</option>
                    <option value="1410">1410mm</option>
                    <option value="1415">1415mm</option>
                    <option value="1420">1420mm</option>
                    <option value="1425">1425mm</option>
                    <option value="1430">1430mm</option>
                    <option value="1435">1435mm</option>
                    <option value="1440">1440mm</option>
                    <option value="1445">1445mm</option>
                    <option value="1450">1450mm</option>
                    <option value="1455">1455mm</option>
                    <option value="1460">1460mm</option>
                    <option value="1465">1465mm</option>
                    <option value="1470">1470mm</option>
                    <option value="1475">1475mm</option>
                    <option value="1480">1480mm</option>
                    <option value="1485">1485mm</option>
                    <option value="1490">1490mm</option>
                    <option value="1495">1495mm</option>
                    <option value="1500">1500mm</option>
                    <option value="1505">1505mm</option>
                    <option value="1510">1510mm</option>
                    <option value="1515">1515mm</option>
                    <option value="1520">1520mm</option>
                    <option value="1525">1525mm</option>
                    <option value="1530">1530mm</option>
                    <option value="1535">1535mm</option>
                    <option value="1540">1540mm</option>
                    <option value="1545">1545mm</option>
                    <option value="1550">1550mm</option>
                    <option value="1555">1555mm</option>
                    <option value="1560">1560mm</option>
                    <option value="1565">1565mm</option>
                    <option value="1570">1570mm</option>
                    <option value="1575">1575mm</option>
                    <option value="1580">1580mm</option>
                    <option value="1585">1585mm</option>
                    <option value="1590">1590mm</option>
                    <option value="1595">1595mm</option>
                    <option value="1600">1600mm</option>
                    <option value="1605">1605mm</option>
                    <option value="1610">1610mm</option>
                    <option value="1615">1615mm</option>
                    <option value="1620">1620mm</option>
                    <option value="1625">1625mm</option>
                    <option value="1630">1630mm</option>
                    <option value="1635">1635mm</option>
                    <option value="1640">1640mm</option>
                    <option value="1645">1645mm</option>
                    <option value="1650">1650mm</option>
                    <option value="1655">1655mm</option>
                    <option value="1660">1660mm</option>
                    <option value="1665">1665mm</option>
                    <option value="1670">1670mm</option>
                    <option value="1675">1675mm</option>
                    <option value="1680">1680mm</option>
                    <option value="1685">1685mm</option>
                    <option value="1690">1690mm</option>
                    <option value="1695">1695mm</option>
                    <option value="1700">1700mm</option>
                    <option value="1705">1705mm</option>
                    <option value="1710">1710mm</option>
                    <option value="1715">1715mm</option>
                    <option value="1720">1720mm</option>
                    <option value="1725">1725mm</option>
                    <option value="1730">1730mm</option>
                    <option value="1735">1735mm</option>
                    <option value="1740">1740mm</option>
                    <option value="1745">1745mm</option>
                    <option value="1750">1750mm</option>
                    <option value="1755">1755mm</option>
                    <option value="1760">1760mm</option>
                    <option value="1765">1765mm</option>
                    <option value="1770">1770mm</option>
                    <option value="1775">1775mm</option>
                    <option value="1780">1780mm</option>
                    <option value="1785">1785mm</option>
                    <option value="1790">1790mm</option>
                    <option value="1795">1795mm</option>
                    <option value="1800">1800mm</option>
                    <option value="1805">1805mm</option>
                    <option value="1810">1810mm</option>
                    <option value="1815">1815mm</option>
                    <option value="1820">1820mm</option>
                    <option value="1825">1825mm</option>
                    <option value="1830">1830mm</option>
                    <option value="1835">1835mm</option>
                    <option value="1840">1840mm</option>
                    <option value="1845">1845mm</option>
                    <option value="1850">1850mm</option>
                    <option value="1855">1855mm</option>
                    <option value="1860">1860mm</option>
                    <option value="1865">1865mm</option>
                    <option value="1870">1870mm</option>
                    <option value="1875">1875mm</option>
                    <option value="1880">1880mm</option>
                    <option value="1885">1885mm</option>
                    <option value="1890">1890mm</option>
                    <option value="1895">1895mm</option>
                    <option value="1900">1900mm</option>
                    <option value="1905">1905mm</option>
                    <option value="1910">1910mm</option>
                    <option value="1915">1915mm</option>
                    <option value="1920">1920mm</option>
                    <option value="1925">1925mm</option>
                    <option value="1930">1930mm</option>
                    <option value="1935">1935mm</option>
                    <option value="1940">1940mm</option>
                    <option value="1945">1945mm</option>
                    <option value="1950">1950mm</option>
                    <option value="1955">1955mm</option>
                    <option value="1960">1960mm</option>
                    <option value="1965">1965mm</option>
                    <option value="1970">1970mm</option>
                    <option value="1975">1975mm</option>
                    <option value="1980">1980mm</option>
                    <option value="1985">1985mm</option>
                    <option value="1990">1990mm</option>
                    <option value="1995">1995mm</option>
                    <option value="2000">2000mm</option>
                    <option value="2005">2005mm</option>
                    <option value="2010">2010mm</option>
                    <option value="2015">2015mm</option>
                    <option value="2020">2020mm</option>
                    <option value="2025">2025mm</option>
                    <option value="2030">2030mm</option>
                    <option value="2035">2035mm</option>
                    <option value="2040">2040mm</option>
                    <option value="2045">2045mm</option>
                    <option value="2050">2050mm</option>
                    <option value="2055">2055mm</option>
                    <option value="2060">2060mm</option>
                    <option value="2065">2065mm</option>
                    <option value="2070">2070mm</option>
                    <option value="2075">2075mm</option>
                    <option value="2080">2080mm</option>
                    <option value="2085">2085mm</option>
                    <option value="2090">2090mm</option>
                    <option value="2095">2095mm</option>
                    <option value="2100">2100mm</option>
                    <option value="2105">2105mm</option>
                    <option value="2110">2110mm</option>
                    <option value="2115">2115mm</option>
                    <option value="2120">2120mm</option>
                    <option value="2125">2125mm</option>
                    <option value="2130">2130mm</option>
                    <option value="2135">2135mm</option>
                    <option value="2140">2140mm</option>
                    <option value="2145">2145mm</option>
                    <option value="2150">2150mm</option>
                    <option value="2155">2155mm</option>
                    <option value="2160">2160mm</option>
                    <option value="2165">2165mm</option>
                    <option value="2170">2170mm</option>
                    <option value="2175">2175mm</option>
                    <option value="2180">2180mm</option>
                    <option value="2185">2185mm</option>
                    <option value="2190">2190mm</option>
                    <option value="2195">2195mm</option>
                    <option value="2200">2200mm</option>
                    <option value="2205">2205mm</option>
                    <option value="2210">2210mm</option>
                    <option value="2215">2215mm</option>
                    <option value="2220">2220mm</option>
                    <option value="2225">2225mm</option>
                    <option value="2230">2230mm</option>
                    <option value="2235">2235mm</option>
                    <option value="2240">2240mm</option>
                    <option value="2245">2245mm</option>
                    <option value="2250">2250mm</option>
                    <option value="2255">2255mm</option>
                    <option value="2260">2260mm</option>
                    <option value="2265">2265mm</option>
                    <option value="2270">2270mm</option>
                    <option value="2275">2275mm</option>
                    <option value="2280">2280mm</option>
                    <option value="2285">2285mm</option>
                    <option value="2290">2290mm</option>
                    <option value="2295">2295mm</option>
                    <option value="2300">2300mm</option>
                    <option value="2305">2305mm</option>
                    <option value="2310">2310mm</option>
                    <option value="2315">2315mm</option>
                    <option value="2320">2320mm</option>
                    <option value="2325">2325mm</option>
                    <option value="2330">2330mm</option>
                    <option value="2335">2335mm</option>
                    <option value="2340">2340mm</option>
                    <option value="2345">2345mm</option>
                    <option value="2350">2350mm</option>
                    <option value="2355">2355mm</option>
                    <option value="2360">2360mm</option>
                    <option value="2365">2365mm</option>
                    <option value="2370">2370mm</option>
                    <option value="2375">2375mm</option>
                    <option value="2380">2380mm</option>
                    <option value="2385">2385mm</option>
                    <option value="2390">2390mm</option>
                    <option value="2395">2395mm</option>
                    <option value="2400">2400mm</option>
                    <option value="2405">2405mm</option>
                    <option value="2410">2410mm</option>
                    <option value="2415">2415mm</option>
                    <option value="2420">2420mm</option>
                    <option value="2425">2425mm</option>
                    <option value="2430">2430mm</option>
                    <option value="2435">2435mm</option>
                    <option value="2440">2440mm</option>
                    <option value="2445">2445mm</option>
                    <option value="2450">2450mm</option>
                    <option value="2455">2455mm</option>
                    <option value="2460">2460mm</option>
                    <option value="2465">2465mm</option>
                    <option value="2470">2470mm</option>
                    <option value="2475">2475mm</option>
                    <option value="2480">2480mm</option>
                    <option value="2485">2485mm</option>
                    <option value="2490">2490mm</option>
                    <option value="2495">2495mm</option>
                    <option value="2500">2500mm</option>
                    <option value="2505">2505mm</option>
                    <option value="2510">2510mm</option>
                    <option value="2515">2515mm</option>
                    <option value="2520">2520mm</option>
                    <option value="2525">2525mm</option>
                    <option value="2530">2530mm</option>
                    <option value="2535">2535mm</option>
                    <option value="2540">2540mm</option>
                    <option value="2545">2545mm</option>
                    <option value="2550">2550mm</option>
                    <option value="2555">2555mm</option>
                    <option value="2560">2560mm</option>
                    <option value="2565">2565mm</option>
                    <option value="2570">2570mm</option>
                    <option value="2575">2575mm</option>
                    <option value="2580">2580mm</option>
                    <option value="2585">2585mm</option>
                    <option value="2590">2590mm</option>
                    <option value="2595">2595mm</option>
                    <option value="2600" selected>2600mm</option>
                    <option value="2605">2605mm</option>
                    <option value="2610">2610mm</option>
                    <option value="2615">2615mm</option>
                    <option value="2620">2620mm</option>
                    <option value="2625">2625mm</option>
                    <option value="2630">2630mm</option>
                    <option value="2635">2635mm</option>
                    <option value="2640">2640mm</option>
                    <option value="2645">2645mm</option>
                    <option value="2650">2650mm</option>
                    <option value="2655">2655mm</option>
                    <option value="2660">2660mm</option>
                    <option value="2665">2665mm</option>
                    <option value="2670">2670mm</option>
                    <option value="2675">2675mm</option>
                    <option value="2680">2680mm</option>
                    <option value="2685">2685mm</option>
                    <option value="2690">2690mm</option>
                    <option value="2695">2695mm</option>
                    <option value="2700">2700mm</option>
                    <option value="2705">2705mm</option>
                    <option value="2710">2710mm</option>
                    <option value="2715">2715mm</option>
                    <option value="2720">2720mm</option>
                    <option value="2725">2725mm</option>
                    <option value="2730">2730mm</option>
                    <option value="2735">2735mm</option>
                    <option value="2740">2740mm</option>
                    <option value="2745">2745mm</option>
                    <option value="2750">2750mm</option>
                    <option value="2755">2755mm</option>
                    <option value="2760">2760mm</option>
                    <option value="2765">2765mm</option>
                    <option value="2770">2770mm</option>
                    <option value="2775">2775mm</option>
                    <option value="2780">2780mm</option>
                    <option value="2785">2785mm</option>
                    <option value="2790">2790mm</option>
                    <option value="2795">2795mm</option>
                    <option value="2800">2800mm</option>
                    <option value="2805">2805mm</option>
                    <option value="2810">2810mm</option>
                    <option value="2815">2815mm</option>
                    <option value="2820">2820mm</option>
                    <option value="2825">2825mm</option>
                    <option value="2830">2830mm</option>
                    <option value="2835">2835mm</option>
                    <option value="2840">2840mm</option>
                    <option value="2845">2845mm</option>
                    <option value="2850">2850mm</option>
                    <option value="2855">2855mm</option>
                    <option value="2860">2860mm</option>
                    <option value="2865">2865mm</option>
                    <option value="2870">2870mm</option>
                    <option value="2875">2875mm</option>
                    <option value="2880">2880mm</option>
                    <option value="2885">2885mm</option>
                    <option value="2890">2890mm</option>
                    <option value="2895">2895mm</option>
                    <option value="2900">2900mm</option>
                    <option value="2905">2905mm</option>
                    <option value="2910">2910mm</option>
                    <option value="2915">2915mm</option>
                    <option value="2920">2920mm</option>
                    <option value="2925">2925mm</option>
                    <option value="2930">2930mm</option>
                    <option value="2935">2935mm</option>
                    <option value="2940">2940mm</option>
                    <option value="2945">2945mm</option>
                    <option value="2950">2950mm</option>
                    <option value="2955">2955mm</option>
                    <option value="2960">2960mm</option>
                    <option value="2965">2965mm</option>
                    <option value="2970">2970mm</option>
                    <option value="2975">2975mm</option>
                    <option value="2980">2980mm</option>
                    <option value="2985">2985mm</option>
                    <option value="2990">2990mm</option>
                    <option value="2995">2995mm</option>
                    <option value="3000">3000mm</option>
                    <option value="3005">3005mm</option>
                    <option value="3010">3010mm</option>
                    <option value="3015">3015mm</option>
                    <option value="3020">3020mm</option>
                    <option value="3025">3025mm</option>
                    <option value="3030">3030mm</option>
                    <option value="3035">3035mm</option>
                    <option value="3040">3040mm</option>
                    <option value="3045">3045mm</option>
                    <option value="3050">3050mm</option>
                    <option value="3055">3055mm</option>
                    <option value="3060">3060mm</option>
                    <option value="3065">3065mm</option>
                    <option value="3070">3070mm</option>
                    <option value="3075">3075mm</option>
                    <option value="3080">3080mm</option>
                    <option value="3085">3085mm</option>
                    <option value="3090">3090mm</option>
                    <option value="3095">3095mm</option>
                    <option value="3100">3100mm</option>
                    <option value="3105">3105mm</option>
                    <option value="3110">3110mm</option>
                    <option value="3115">3115mm</option>
                    <option value="3120">3120mm</option>
                    <option value="3125">3125mm</option>
                    <option value="3130">3130mm</option>
                    <option value="3135">3135mm</option>
                    <option value="3140">3140mm</option>
                    <option value="3145">3145mm</option>
                    <option value="3150">3150mm</option>
                    <option value="3155">3155mm</option>
                    <option value="3160">3160mm</option>
                    <option value="3165">3165mm</option>
                    <option value="3170">3170mm</option>
                    <option value="3175">3175mm</option>
                    <option value="3180">3180mm</option>
                    <option value="3185">3185mm</option>
                    <option value="3190">3190mm</option>
                    <option value="3195">3195mm</option>
                    <option value="3200">3200mm</option>
                    <option value="3205">3205mm</option>
                    <option value="3210">3210mm</option>
                    <option value="3215">3215mm</option>
                    <option value="3220">3220mm</option>
                    <option value="3225">3225mm</option>
                    <option value="3230">3230mm</option>
                    <option value="3235">3235mm</option>
                    <option value="3240">3240mm</option>
                    <option value="3245">3245mm</option>
                    <option value="3250">3250mm</option>
                    <option value="3255">3255mm</option>
                    <option value="3260">3260mm</option>
                    <option value="3265">3265mm</option>
                    <option value="3270">3270mm</option>
                    <option value="3275">3275mm</option>
                    <option value="3280">3280mm</option>
                    <option value="3285">3285mm</option>
                    <option value="3290">3290mm</option>
                    <option value="3295">3295mm</option>
                    <option value="3300">3300mm</option>
                    <option value="3305">3305mm</option>
                    <option value="3310">3310mm</option>
                    <option value="3315">3315mm</option>
                    <option value="3320">3320mm</option>
                    <option value="3325">3325mm</option>
                    <option value="3330">3330mm</option>
                    <option value="3335">3335mm</option>
                    <option value="3340">3340mm</option>
                    <option value="3345">3345mm</option>
                    <option value="3350">3350mm</option>
                    <option value="3355">3355mm</option>
                    <option value="3360">3360mm</option>
                    <option value="3365">3365mm</option>
                    <option value="3370">3370mm</option>
                    <option value="3375">3375mm</option>
                    <option value="3380">3380mm</option>
                    <option value="3385">3385mm</option>
                    <option value="3390">3390mm</option>
                    <option value="3395">3395mm</option>
                    <option value="3400">3400mm</option>
                    <option value="3405">3405mm</option>
                    <option value="3410">3410mm</option>
                    <option value="3415">3415mm</option>
                    <option value="3420">3420mm</option>
                    <option value="3425">3425mm</option>
                    <option value="3430">3430mm</option>
                    <option value="3435">3435mm</option>
                    <option value="3440">3440mm</option>
                    <option value="3445">3445mm</option>
                    <option value="3450">3450mm</option>
                    <option value="3455">3455mm</option>
                    <option value="3460">3460mm</option>
                    <option value="3465">3465mm</option>
                    <option value="3470">3470mm</option>
                    <option value="3475">3475mm</option>
                    <option value="3480">3480mm</option>
                    <option value="3485">3485mm</option>
                    <option value="3490">3490mm</option>
                    <option value="3495">3495mm</option>
                    <option value="3500">3500mm</option>
                    <option value="3505">3505mm</option>
                    <option value="3510">3510mm</option>
                    <option value="3515">3515mm</option>
                    <option value="3520">3520mm</option>
                    <option value="3525">3525mm</option>
                    <option value="3530">3530mm</option>
                    <option value="3535">3535mm</option>
                    <option value="3540">3540mm</option>
                    <option value="3545">3545mm</option>
                    <option value="3550">3550mm</option>
                    <option value="3555">3555mm</option>
                    <option value="3560">3560mm</option>
                    <option value="3565">3565mm</option>
                    <option value="3570">3570mm</option>
                    <option value="3575">3575mm</option>
                    <option value="3580">3580mm</option>
                    <option value="3585">3585mm</option>
                    <option value="3590">3590mm</option>
                    <option value="3595">3595mm</option>
                    <option value="3600">3600mm</option>
                    <option value="3605">3605mm</option>
                    <option value="3610">3610mm</option>
                    <option value="3615">3615mm</option>
                    <option value="3620">3620mm</option>
                    <option value="3625">3625mm</option>
                    <option value="3630">3630mm</option>
                    <option value="3635">3635mm</option>
                    <option value="3640">3640mm</option>
                    <option value="3645">3645mm</option>
                    <option value="3650">3650mm</option>
                    <option value="3655">3655mm</option>
                    <option value="3660">3660mm</option>
                    <option value="3665">3665mm</option>
                    <option value="3670">3670mm</option>
                    <option value="3675">3675mm</option>
                    <option value="3680">3680mm</option>
                    <option value="3685">3685mm</option>
                    <option value="3690">3690mm</option>
                    <option value="3695">3695mm</option>
                    <option value="3700">3700mm</option>
                    <option value="3705">3705mm</option>
                    <option value="3710">3710mm</option>
                    <option value="3715">3715mm</option>
                    <option value="3720">3720mm</option>
                    <option value="3725">3725mm</option>
                    <option value="3730">3730mm</option>
                    <option value="3735">3735mm</option>
                    <option value="3740">3740mm</option>
                    <option value="3745">3745mm</option>
                    <option value="3750">3750mm</option>
                    <option value="3755">3755mm</option>
                    <option value="3760">3760mm</option>
                    <option value="3765">3765mm</option>
                    <option value="3770">3770mm</option>
                    <option value="3775">3775mm</option>
                    <option value="3780">3780mm</option>
                    <option value="3785">3785mm</option>
                    <option value="3790">3790mm</option>
                    <option value="3795">3795mm</option>
                    <option value="3800">3800mm</option>
                    <option value="3805">3805mm</option>
                    <option value="3810">3810mm</option>
                    <option value="3815">3815mm</option>
                    <option value="3820">3820mm</option>
                    <option value="3825">3825mm</option>
                    <option value="3830">3830mm</option>
                    <option value="3835">3835mm</option>
                    <option value="3840">3840mm</option>
                    <option value="3845">3845mm</option>
                    <option value="3850">3850mm</option>
                    <option value="3855">3855mm</option>
                    <option value="3860">3860mm</option>
                    <option value="3865">3865mm</option>
                    <option value="3870">3870mm</option>
                    <option value="3875">3875mm</option>
                    <option value="3880">3880mm</option>
                    <option value="3885">3885mm</option>
                    <option value="3890">3890mm</option>
                    <option value="3895">3895mm</option>
                    <option value="3900">3900mm</option>
                    <option value="3905">3905mm</option>
                    <option value="3910">3910mm</option>
                    <option value="3915">3915mm</option>
                    <option value="3920">3920mm</option>
                    <option value="3925">3925mm</option>
                    <option value="3930">3930mm</option>
                    <option value="3935">3935mm</option>
                    <option value="3940">3940mm</option>
                    <option value="3945">3945mm</option>
                    <option value="3950">3950mm</option>
                    <option value="3955">3955mm</option>
                    <option value="3960">3960mm</option>
                    <option value="3965">3965mm</option>
                    <option value="3970">3970mm</option>
                    <option value="3975">3975mm</option>
                    <option value="3980">3980mm</option>
                    <option value="3985">3985mm</option>
                    <option value="3990">3990mm</option>
                    <option value="3995">3995mm</option>
                    <option value="4000">4000mm</option>
                </select>
                </select>

            </div>
            <div class="form-group" id="celingHeight">
                <label for="" class="mb-1 mt-3">Ceiling Height</label>
                <div class="">
                    <select class="form-control" id="">
                        <option value="2000">2000mm</option>
                        <option value="2010">2010mm</option>
                        <option value="2020">2020mm</option>
                        <option value="2030">2030mm</option>
                        <option value="2040">2040mm</option>
                        <option value="2050">2050mm</option>
                        <option value="2060">2060mm</option>
                        <option value="2070">2070mm</option>
                        <option value="2080">2080mm</option>
                        <option value="2090">2090mm</option>
                        <option value="2100">2100mm</option>
                        <option value="2110">2110mm</option>
                        <option value="2120">2120mm</option>
                        <option value="2130">2130mm</option>
                        <option value="2140">2140mm</option>
                        <option value="2150">2150mm</option>
                        <option value="2160">2160mm</option>
                        <option value="2170">2170mm</option>
                        <option value="2180">2180mm</option>
                        <option value="2190">2190mm</option>
                        <option value="2200">2200mm</option>
                        <option value="2210">2210mm</option>
                        <option value="2220">2220mm</option>
                        <option value="2230">2230mm</option>
                        <option value="2240">2240mm</option>
                        <option value="2250">2250mm</option>
                        <option value="2260">2260mm</option>
                        <option value="2270">2270mm</option>
                        <option value="2280">2280mm</option>
                        <option value="2290">2290mm</option>
                        <option value="2300">2300mm</option>
                        <option value="2310">2310mm</option>
                        <option value="2320">2320mm</option>
                        <option value="2330">2330mm</option>
                        <option value="2340">2340mm</option>
                        <option value="2350" selected>2350mm</option>
                        <option value="2360">2360mm</option>
                        <option value="2370">2370mm</option>
                        <option value="2380">2380mm</option>
                        <option value="2390">2390mm</option>
                        <option value="2400">2400mm</option>
                        <option value="2410">2410mm</option>
                        <option value="2420">2420mm</option>
                        <option value="2430">2430mm</option>
                        <option value="2440">2440mm</option>
                        <option value="2450">2450mm</option>
                        <option value="2460">2460mm</option>
                        <option value="2470">2470mm</option>
                        <option value="2480">2480mm</option>
                        <option value="2490">2490mm</option>
                        <option value="2500">2500mm</option>
                        <option value="2510">2510mm</option>
                        <option value="2520">2520mm</option>
                        <option value="2530">2530mm</option>
                        <option value="2540">2540mm</option>
                        <option value="2550">2550mm</option>
                        <option value="2560">2560mm</option>
                        <option value="2570">2570mm</option>
                        <option value="2580">2580mm</option>
                        <option value="2590">2590mm</option>
                        <option value="2600">2600mm</option>
                        <option value="2610">2610mm</option>
                        <option value="2620">2620mm</option>
                        <option value="2630">2630mm</option>
                        <option value="2640">2640mm</option>
                        <option value="2650">2650mm</option>
                        <option value="2660">2660mm</option>
                        <option value="2670">2670mm</option>
                        <option value="2680">2680mm</option>
                        <option value="2690">2690mm</option>
                        <option value="2700">2700mm</option>
                        <option value="2710">2710mm</option>
                        <option value="2720">2720mm</option>
                        <option value="2730">2730mm</option>
                        <option value="2740">2740mm</option>
                        <option value="2750">2750mm</option>
                        <option value="2760">2760mm</option>
                        <option value="2770">2770mm</option>
                        <option value="2780">2780mm</option>
                        <option value="2790">2790mm</option>
                        <option value="2800">2800mm</option>
                        <option value="2810">2810mm</option>
                        <option value="2820">2820mm</option>
                        <option value="2830">2830mm</option>
                        <option value="2840">2840mm</option>
                        <option value="2850">2850mm</option>
                        <option value="2860">2860mm</option>
                        <option value="2870">2870mm</option>
                        <option value="2880">2880mm</option>
                        <option value="2890">2890mm</option>
                        <option value="2900">2900mm</option>
                        <option value="2910">2910mm</option>
                        <option value="2920">2920mm</option>
                        <option value="2930">2930mm</option>
                        <option value="2940">2940mm</option>
                        <option value="2950">2950mm</option>
                        <option value="2960">2960mm</option>
                        <option value="2970">2970mm</option>
                        <option value="2980">2980mm</option>
                        <option value="2990">2990mm</option>
                        <option value="3000">3000mm</option>

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="risers" class="mb-1 mt-3">Number of Risers</label>
                <select class="form-control" id="risers">
                    <option value="12">12</option>
                    <option value="13" selected>13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                </select>
            </div>

            <div class="form-group">
                <label for="individual_going" class="mb-1 mt-3">Individual Going</label>
                <select class="form-control" id="individual_going">
                    @for ($i = 222; $i <= 280; $i = $i + 1)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor


                </select>
            </div>


            <div class="form-group">
                <label for="width" class="mb-1 mt-3">Width</label>
                <select class="form-control" id="widthSVG">
                    @for ($i = 600; $i <= 1000; $i = $i + 5)
                        <option value="{{ $i }}" {{ $i == 865 ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor


                </select>
            </div>

        </div>

        <div class="col-lg-9">
            <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" id="svg" width="1004"
                height="700">
                <defs>
                    <pattern id="mdf" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/mdf.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <pattern id="oak" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/oak.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <pattern id="redwood" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/pine.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <pattern id="whitewood" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/softwood.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <pattern id="whiteprimed" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/whiteprimed.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <pattern id="false" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/none.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <pattern id="0" patternUnits="userSpaceOnUse" width="1000px" height="1000px">
                        <image style="-moz-user-select: text;"
                            href="https://cdn.stairbox.com/assets/stairbuilder/textures/none.jpg" width="1000px"
                            height="1000px" preserveAspectRatio="none" transform="translate (0,0) rotate(0)"></image>
                    </pattern>
                    <marker id="startarrow" markerWidth="10" markerHeight="7" refX="0" refY="3.5"
                        orient="auto">
                        <polygon points="10 0, 10 7, 0 3.5" fill="red"></polygon>
                    </marker>
                    <marker id="endarrow" markerWidth="10" markerHeight="7" refX="10" refY="3.5"
                        orient="auto" markerUnits="strokeWidth">
                        <polygon points="0 0, 10 3.5, 0 7" fill="red"></polygon>
                    </marker>
                </defs>
                <g id="myGroup"
                    transform="translate (470,592.085501858736) rotate(180) scale(-0.18215613382899626,0.18215613382899626)">
                    <g>
                        <g transform="translate(0 0)  rotate(0)"></g>
                        <g transform="translate(0 0)  rotate(0)">
                            <g id="noOfS">
                                <g transform="translate(-413.5 0)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread1" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread1" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#1</text>
                                </g>
                                <g transform="translate(-413.5 222)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread2" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread2" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#2</text>
                                </g>
                                <g transform="translate(-413.5 444)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread3" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread3" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#3</text>
                                </g>
                                <g transform="translate(-413.5 666)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread4" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread4" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#4</text>
                                </g>
                                <g transform="translate(-413.5 888)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread5" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread5" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#5</text>
                                </g>
                                <g transform="translate(-413.5 1110)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread6" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread6" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#6</text>
                                </g>
                                <g transform="translate(-413.5 1332)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread7" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread7" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#7</text>
                                </g>
                                <g transform="translate(-413.5 1554)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread8" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread8" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#8</text>
                                </g>
                                <g transform="translate(-413.5 1776)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread9" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread9" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#9</text>
                                </g>
                                <g transform="translate(-413.5 1998)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread10" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread10" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#10</text>
                                </g>
                                <g transform="translate(-413.5 2220)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread11" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread11" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#11</text>
                                </g>
                                <g transform="translate(-413.5 2442)  rotate(0)">
                                    <rect x="0" y="-16" width="827" height="238" fill="url(#mdf)"
                                        style="stroke:black;stroke-width:2;;" id="run1_tread12" class=""></rect>
                                    <rect x="0" y="0" width="827" height="10" fill="none"
                                        style="stroke:black;stroke-width:1;;" id="run1_tread12" class=""></rect>
                                    <text x="388.5" y="-131"
                                        style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                        transform="translate (0,0) rotate(180) scale(-1,1)">#12</text>
                                </g>
                            </g>
                            <g>
                                <g transform="translate(405.5 0)  rotate(0)"></g>
                                <g transform="translate(-432.5 0)  rotate(0)"></g>
                            </g>
                            <g></g> <text x="0" y="-0"
                                style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                transform="translate (0,0) rotate(180) scale(-1,1)">run1</text>
                        </g>
                        <g id="lastUp" transform="translate(0 2664)  rotate(0)">
                            <g transform="translate(-413.5 0)  rotate(0)">
                                <rect x="0" y="-16" width="827" height="86" fill="url(#mdf)"
                                    style="stroke:black;stroke-width:2;;" id="nosing_tread" class=""></rect>
                                <rect x="0" y="0" width="827" height="10" fill="none"
                                    style="stroke:black;stroke-width:1;;" id="nosing_tread" class=""></rect>
                                <text x="388.5" y="-55" id="lastUpText"
                                    style="font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;"
                                    transform="translate (0,0) rotate(180) scale(-1,1)">#13</text>
                            </g>
                        </g>
                    </g>
                    <g>
                        <g transform="translate(0 0)  rotate(0)"></g>
                        <g transform="translate(0 0)  rotate(0)">
                            <g id="leftHandle">
                                <g transform="translate(-413.5 0)  rotate(0)"></g>
                                <g transform="translate(-413.5 222)  rotate(0)"></g>
                                <g transform="translate(-413.5 444)  rotate(0)"></g>
                                <g transform="translate(-413.5 666)  rotate(0)"></g>
                                <g transform="translate(-413.5 888)  rotate(0)"></g>
                                <g transform="translate(-413.5 1110)  rotate(0)"></g>
                                <g transform="translate(-413.5 1332)  rotate(0)"></g>
                                <g transform="translate(-413.5 1554)  rotate(0)"></g>
                                <g transform="translate(-413.5 1776)  rotate(0)"></g>
                                <g transform="translate(-413.5 1998)  rotate(0)"></g>
                                <g transform="translate(-413.5 2220)  rotate(0)"></g>
                                <g transform="translate(-413.5 2442)  rotate(0)"></g>
                            </g>
                            <g>
                                <g transform="translate(405.5 0)  rotate(0)">
                                    <rect x="0" y="-120" width="27" height="2904" fill="url(#whitewood)"
                                        style="stroke:black;stroke-width:1;;" id="run1_rightString" class="">
                                    </rect>
                                </g>
                                <g transform="translate(-432.5 0)  rotate(0)">
                                    <rect x="0" y="-120" width="27" height="2904" fill="url(#whitewood)"
                                        style="stroke:black;stroke-width:1;;" id="run1_leftString" class="">
                                    </rect>
                                </g>
                            </g>
                            <g></g>
                        </g>
                        <g transform="translate(0 2664)  rotate(0)">
                            <g transform="translate(-413.5 0)  rotate(0)"></g>
                        </g>
                    </g>
                    <pattern id="diagonalHatch" patternUnits="userSpaceOnUse" width="80" height="80">
                        <path d="M-20,20 l40,-40
                                                                    M0,80 l80,-80
                                                                    M60,100 l40,-40" style="stroke:grey; stroke-width:4">
                        </path>
                    </pattern>
                    <path d="" fill="white" fill-opacity="0.3"></path>
                    <path d="" fill="url(#diagonalHatch)" fill-opacity="1" stroke-width="6" stroke="black"></path>
                    <g>
                        <g transform="translate(0 0)  rotate(0)"></g>
                        <g transform="translate(0 0)  rotate(0)">
                            <g id="rightHandle">
                                <g transform="translate(-413.5 0)  rotate(0)"></g>
                                <g transform="translate(-413.5 222)  rotate(0)"></g>
                                <g transform="translate(-413.5 444)  rotate(0)"></g>
                                <g transform="translate(-413.5 666)  rotate(0)"></g>
                                <g transform="translate(-413.5 888)  rotate(0)"></g>
                                <g transform="translate(-413.5 1110)  rotate(0)"></g>
                                <g transform="translate(-413.5 1332)  rotate(0)"></g>
                                <g transform="translate(-413.5 1554)  rotate(0)"></g>
                                <g transform="translate(-413.5 1776)  rotate(0)"></g>
                                <g transform="translate(-413.5 1998)  rotate(0)"></g>
                                <g transform="translate(-413.5 2220)  rotate(0)"></g>
                                <g transform="translate(-413.5 2442)  rotate(0)"></g>
                            </g>
                            <g>
                                <g transform="translate(405.5 0)  rotate(0)"></g>
                                <g transform="translate(-432.5 0)  rotate(0)"></g>
                            </g>
                            <g></g>
                        </g>
                        <g transform="translate(0 2664)  rotate(0)">
                            <g transform="translate(-413.5 0)  rotate(0)"></g>
                        </g>
                    </g>
                    <g>
                        <g transform="translate(0 0)  rotate(0)"></g>
                        <g transform="translate(0 0)  rotate(0)">
                            <g>
                                <g transform="translate(-413.5 0)  rotate(0)"></g>
                                <g transform="translate(-413.5 222)  rotate(0)"></g>
                                <g transform="translate(-413.5 444)  rotate(0)"></g>
                                <g transform="translate(-413.5 666)  rotate(0)"></g>
                                <g transform="translate(-413.5 888)  rotate(0)"></g>
                                <g transform="translate(-413.5 1110)  rotate(0)"></g>
                                <g transform="translate(-413.5 1332)  rotate(0)"></g>
                                <g transform="translate(-413.5 1554)  rotate(0)"></g>
                                <g transform="translate(-413.5 1776)  rotate(0)"></g>
                                <g transform="translate(-413.5 1998)  rotate(0)"></g>
                                <g transform="translate(-413.5 2220)  rotate(0)"></g>
                                <g transform="translate(-413.5 2442)  rotate(0)"></g>
                            </g>
                            <g>
                                <g transform="translate(405.5 0)  rotate(0)"></g>
                                <g transform="translate(-432.5 0)  rotate(0)"></g>
                            </g>
                            <g></g>
                        </g>
                        <g transform="translate(0 2664)  rotate(0)">
                            <g transform="translate(-413.5 0)  rotate(0)"></g>
                        </g>
                    </g>

                    <g>
                        <g transform="translate(0 0)  rotate(0)"></g>
                        <g transform="translate(0 0)  rotate(0)">
                            <g>
                                <g transform="translate(-413.5 0)  rotate(0)"></g>
                                <g transform="translate(-413.5 222)  rotate(0)"></g>
                                <g transform="translate(-413.5 444)  rotate(0)"></g>
                                <g transform="translate(-413.5 666)  rotate(0)"></g>
                                <g transform="translate(-413.5 888)  rotate(0)"></g>
                                <g transform="translate(-413.5 1110)  rotate(0)"></g>
                                <g transform="translate(-413.5 1332)  rotate(0)"></g>
                                <g transform="translate(-413.5 1554)  rotate(0)"></g>
                                <g transform="translate(-413.5 1776)  rotate(0)"></g>
                                <g transform="translate(-413.5 1998)  rotate(0)"></g>
                                <g transform="translate(-413.5 2220)  rotate(0)"></g>
                                <g transform="translate(-413.5 2442)  rotate(0)"></g>
                            </g>
                            <g>
                                <g transform="translate(405.5 0)  rotate(0)"></g>
                                <g transform="translate(-432.5 0)  rotate(0)"></g>
                            </g>
                            <g></g>
                        </g>
                        {{-- <g transform="translate(0 2664)  rotate(0)">
                            <g transform="translate(-413.5 0)  rotate(0)"></g>
                        </g>
                        <line x1="532.5" y1="-16" x2="532.5" y2="2674" stroke="black"
                            stroke-width="3" marker-end="url(#endarrow)" marker-start="url(#startarrow)"
                            class=""></line>
                        <rect x="477.5" y="1319" width="200" height="100" fill="white"
                            transform="translate (-20,-30)" opacity="0.6" class=""></rect>
                        <text x="477.5" y="-1319" style="font-size: 75px; font-family: Arial, Helvetica, sans-serif;"
                            transform="translate (0,0) rotate(180) scale(-1,1)" class="">2690</text>
                        <line x1="-432.5" y1="-250" x2="432.5" y2="-250" stroke="black"
                            stroke-width="3" marker-end="url(#endarrow)" marker-start="url(#startarrow)"
                            class=""></line>
                        <rect x="-50" y="-250" width="200" height="100" fill="white"
                            transform="translate (-20,-30)" opacity="0.6" class=""></rect>
                        <text x="-50" y="270" style="font-size: 75px; font-family: Arial, Helvetica, sans-serif;"
                            transform="translate (0,0) rotate(180) scale(-1,1)" class="">865</text> --}}
                    </g>
                </g>
            </svg>
        </div>

    </div>
@endsection

@section('pageSpecificJs')
    <script>
        function calculateRightStringerLength(totalRise, individualGoing) {
            var slopeRatio = totalRise / individualGoing;
            var angle = Math.atan(slopeRatio) ; // Convert radians to degrees
            var stringerLength = Math.sqrt(Math.pow(totalRise, 2) + Math.pow(individualGoing, 2));
            return stringerLength;
        }

        function updateLeftRightStrings() {
            let $leftString = $('#run1_leftString');
            let $rightString = $('#run1_rightString');
            // let leftStringValue = calculateRightStringerLength($('#FloorHeight').val(), document.getElementById(
            //     'individual_going').value)
            let leftStringValue = parseInt($('#risers').val()) *parseInt($('#individual_going').val())
            $leftString.attr('height', leftStringValue)
            $rightString.attr('height', leftStringValue)
        };



        var newOptions = [];
        var floorHeight = 0;
        $('#FloorHeight').on('change', function() {
            floorHeight = parseInt($(this).val());
            if ((floorHeight) <= 2100) {
                $('#celingHeight').hide();
            } else {
                $('#celingHeight').show();
            }

            if (floorHeight < 500) {
                if (floorHeight < 450)
                    newOptions = [2];
                else if (floorHeight > 450)
                    newOptions = [3];
                $.each(newOptions, function(index, value) {
                    var absoluteValue = Math.abs(floorHeight / value);
                    $("#risers").empty().append('<option value="' + value + '">' + value + ' @ ' +
                        absoluteValue + 'mm</option>');
                });
                // $('#svg').html(svg_300);

            } else if (floorHeight >= 500 && floorHeight < 700) {
                if (floorHeight >= 600 && floorHeight <= 660) {
                    $("#risers").empty();
                    newOptions = [3, 4];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_500);
            } else if (floorHeight >= 700 && floorHeight < 900) {
                if (floorHeight < 750) {
                    $("#risers").empty();
                    newOptions = [4];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                } else if (floorHeight >= 750 && floorHeight <= 880) {
                    $("#risers").empty();
                    newOptions = [4, 5];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                } else if (floorHeight > 880 && floorHeight < 900) {
                    $("#risers").empty();
                    newOptions = [5];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_700);
            } else if (floorHeight >= 900 && floorHeight < 1100) {
                if (floorHeight >= 900 && floorHeight < 1050) {
                    $("#risers").empty();
                    newOptions = [5, 6];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                } else if (floorHeight > 1050 && floorHeight < 1100) {
                    $("#risers").empty();
                    newOptions = [5, 6, 7];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_900);
            } else if (floorHeight >= 1100 && floorHeight < 1300) {
                if (floorHeight > 1100 && floorHeight < 1200) {
                    $("#risers").empty();
                    newOptions = [6, 7];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_1100);
            } else if (floorHeight >= 1300 && floorHeight < 1500) {
                if (floorHeight >= 1200 && floorHeight < 1350) {
                    $("#risers").empty();
                    newOptions = [7, 8];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                } else if (floorHeight >= 1350 && floorHeight < 1500) {
                    $("#risers").empty();
                    newOptions = [7, 8, 9];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_1300);
            } else if (floorHeight >= 1500 && floorHeight < 1700) {
                if (floorHeight >= 1500 && floorHeight < 1545) {
                    $("#risers").empty();
                    newOptions = [7, 8, 9, 10];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');

                        if (value == 8) {
                            $("#risers option[value='8']").prop('selected', true);
                        }
                    });

                } else if (floorHeight > 1545 && floorHeight <= 1645) {
                    $("#risers").empty();
                    newOptions = [8, 9, 10];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_1500);
            } else if (floorHeight >= 1700 && floorHeight < 1900) {
                if (floorHeight > 1650 && floorHeight <= 1765) {
                    $("#risers").empty();
                    newOptions = [8, 9, 10, 11];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                } else if (floorHeight >= 1770 && floorHeight < 1800) {
                    $("#risers").empty();
                    newOptions = [9, 10, 11];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                } else if (floorHeight >= 1800) {
                    $("#risers").empty();
                    newOptions = [9, 10, 11, 12];
                    $.each(newOptions, function(index, value) {
                        var absoluteValue = Math.abs(floorHeight / value).toFixed(1);;
                        $("#risers").append('<option value="' + value + '">' + value + ' @ ' +
                            absoluteValue + 'mm</option>');
                    });
                }
                // $('#svg').html(svg_1700);
            } else if (floorHeight >= 1900 && floorHeight < 2100) {
                // $('#svg').html(svg_1900);
            } else if (floorHeight >= 2100 && floorHeight < 2300) {
                // $('#svg').html(svg_2100);
            } else if (floorHeight >= 2300 && floorHeight < 2500) {
                // $('#svg').html(svg_2300);
            } else if (floorHeight >= 2500 && floorHeight < 2700) {
                // $('#svg').html(svg_2500);
            } else if (floorHeight >= 2700 && floorHeight < 2900) {
                // $('#svg').html(svg_2700);
            } else if (floorHeight >= 2900 && floorHeight < 3100) {
                // $('#svg').html(svg_2900);
            } else if (floorHeight >= 3100 && floorHeight < 3300) {
                // $('#svg').html(svg_3100);
            } else if (floorHeight >= 3300 && floorHeight < 3500) {
                // $('#svg').html(svg_3300);
            } else if (floorHeight >= 3500 && floorHeight < 3700) {
                // $('#svg').html(svg_3500);
            } else if (floorHeight >= 3700 && floorHeight < 3900) {
                // $('#svg').html(svg_3700);
            } else if (floorHeight >= 3900 && floorHeight < 4100) {
                // $('#svg').html(svg_3900);
            }
            updateAllThings()

          

        });

        function updateLastUp(lastNumber) {
            $('#lastUp').attr('transform', 'translate(0 ' + lastNumber + ') rotate(0)');
            $('#lastUpText').text('#' + $('#risers').val())

        }
    </script>
    {{-- for no of risers change --}}
    <script>
        var numberOfSteps

        function updateStepsOnSVG(numberOfSteps) {
            var indiGoing = parseInt(document.getElementById('individual_going').value);
            var noOfS = document.getElementById('noOfS');
            noOfS.innerHTML = ''; // Clear previous content
            var lastIndexThat = 0;
            for (let index = 0; index < numberOfSteps - 1; index++) {
                let stest = index + 1;

                // Create <g> element
                var g = document.createElementNS("http://www.w3.org/2000/svg", "g");
                g.setAttribute('transform', `translate(-413.5 ${index * indiGoing}) rotate(0)`);

                // Create <rect> elements
                var rect1 = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                rect1.setAttribute('x', '0');
                rect1.setAttribute('y', '-16');
                rect1.setAttribute('width', '827');
                rect1.setAttribute('height', '238');
                rect1.setAttribute('fill', 'url(#mdf)');
                rect1.setAttribute('style', 'stroke:black;stroke-width:2;');
                rect1.setAttribute('id', `run1_tread${stest}`);
                rect1.setAttribute('class', '');

                var rect2 = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                rect2.setAttribute('x', '0');
                rect2.setAttribute('y', '0');
                rect2.setAttribute('width', '827');
                rect2.setAttribute('height', '10');
                rect2.setAttribute('fill', 'none');
                rect2.setAttribute('style', 'stroke:black;stroke-width:1;');
                rect2.setAttribute('id', `run1_tread${stest}`);
                rect2.setAttribute('class', '');

                // Create <text> element
                var text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                text.setAttribute('x', '388.5');
                text.setAttribute('y', '-131');
                text.setAttribute('style', 'font-size: 55px; font-family: Arial, Helvetica, sans-serif; color: black;');
                text.setAttribute('transform', 'translate(0,0) rotate(180) scale(-1,1)');
                text.textContent = '#' + stest;

                // Append <rect> elements to <g>
                g.appendChild(rect1);
                g.appendChild(rect2);
                g.appendChild(text);

                // Append <g> to target element
                noOfS.appendChild(g);

            }
            lastIndexThat = (numberOfSteps - 1) * indiGoing;
            return lastIndexThat;
        }


        $('#risers').on('change', function() {
            numberOfSteps = parseInt($(this).val());
            var indiGoing = parseInt($('#individual_going').val());
            $('#noOfS').empty();
            $('#leftHandle').empty();
            updateAllThings()
        });

        $('#widthSVG').on('change', function() {
            var width = parseInt($(this).val());
            for (let index = 1; index < numberOfSteps; index++) {
                let ss = 'run1_tread' + index;
                var rectElement = $(`#${ss}`);
                rectElement.attr('width', width - 38);
            }
            updateAllThings()
        });

        $('#individual_going').on('change', function() {
            var gElements = $('g[transform*="translate(-413.5"]');
            var newY = 0;
            let vall = parseInt($(this).val());
              gElements.each(function() {
                var currentTransform = $(this).attr('transform');
                var translateY = parseInt(currentTransform.match(/translate\(-413.5 (-?\d+)/)[1]);
                var newTransform = currentTransform.replace(/translate\(-413.5 (-?\d+)/,
                    'translate(-413.5 ' + newY);
                $(this).attr('transform', newTransform);
                newY += vall;
            });
        });

        $('#widthSVG').on('change', function(){
          let svgWidth = parseInt($(this).val());
          let totalRisers = parseInt($('#risers').val());
          let newWidth = svgWidth - 38; 

          for (let index = 0; index < totalRisers; index++) {
            let tred = 'run1_tread'+(index+1);
            let $run1TreadGroup =  $('[id="' + tred + '"]');
            $run1TreadGroup.each(function(index) {
              let $rectElements = $(this);
              $rectElements.attr('width', newWidth);
            });
          }
          let noisingTread = 'nosing_tread';

          let $noisingTread =  $('[id="' + noisingTread + '"]');
          $noisingTread.each(function(index) {
              let $rectElements = $(this);
              $rectElements.attr('width', newWidth);
            });
        })



        function updateScale() {
            let floorHeight =parseInt($('#FloorHeight').val());
            let svgWidth = 1004;
            let svgHeight = 700;
            var i = Math.abs(-432.5) + Math.abs(432.5);
            let n = Math.abs(-432.5) + Math.abs(floorHeight);
            let r = .7 * svgWidth / i;
            let a = .7 * svgHeight / n;
            let scale = Math.min(r, a);
            n *= scale;
            i *= scale;
            let minX = (svgWidth - i) / 2 + Math.abs(-432.5 * scale);
            let minY = (svgHeight - n) / 2 + Math.abs(floorHeight * scale);
            var gElement = $('#myGroup');
            // Get the current transform attribute value
            var currentTransform = gElement.attr('transform');
            // Parse the current transform value to extract scale values
            var newTransform = currentTransform.replace(/scale\((-?\d*\.?\d+),(-?\d*\.?\d+)\)/, 'scale(' + -scale + ',' +
                scale + ')');
            gElement.attr('transform', newTransform);
        }

        function updateAllThings() {
            let noOfSteps = parseInt($('#risers').val());
            let lastNumber = updateStepsOnSVG(noOfSteps);
            updateStepsOnSVG(noOfSteps);
            updateLastUp(lastNumber);
            updateScale();
            updateLeftRightStrings();

        }
    </script>
@endsection
