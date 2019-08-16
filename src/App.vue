<template>
    <div id="app">
        <router-view/>
        <el-backtop target="#app"></el-backtop>
    </div>
</template>

<style>
	body,html{
		margin:0;
		padding:0;
        height: 100%;
        width:100%;
        overflow: hidden;
	}
    #app{
        height: 100%;
        width:100%;
        overflow: auto;
    }
	*{
		font-family: '微软雅黑';
		letter-spacing:0.5px;
	}
</style>