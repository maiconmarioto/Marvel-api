import React, {StyleSheet, Dimensions, PixelRatio} from "react-native";
const {width, height, scale} = Dimensions.get("window"),
    vw = width / 100,
    vh = height / 100,
    vmin = Math.min(vw, vh),
    vmax = Math.max(vw, vh);

export default StyleSheet.create({
    "wrapper": {
        "width": 900,
        "marginTop": 0,
        "marginRight": "auto",
        "marginBottom": 0,
        "marginLeft": "auto"
    },
    "query": {
        "width": 700
    },
    "card": {
        "width": 200,
        "float": "left",
        "marginLeft": 10,
        "marginRight": 10,
        "marginBottom": 25
    },
    "comics card": {
        "height": 650
    },
    "characters card": {
        "height": 450
    },
    "card p": {
        "fontSize": 15,
        "color": "#676767"
    },
    "card h5": {
        "lineHeight": 18
    },
    "results": {
        "overflow": "auto"
    },
    "pagination li": {
        "display": "inline-block",
        "paddingTop": 30,
        "paddingRight": 30,
        "paddingBottom": 30,
        "paddingLeft": 30,
        "listStyle": "none"
    }
});