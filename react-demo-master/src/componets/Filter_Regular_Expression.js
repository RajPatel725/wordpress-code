import React, { useState } from "react";

function Filter_Regular_Expression() {
    const string =
        "Lorem ipsum dolor sit amet sit amet consectetur adipisicing elit sit amet. Repellendus sit amet magnam iste voluptates nobis ebitis facilis molestiae cupiditate consequuntur delectus non quae ut aliquid nesciunt voluptas placeat, qui myName aut reiciendis!";

    const [findValue, setFindValue] = useState("");

    const handleSubmit = (event) => {
        event.preventDefault();

        var pattern = new RegExp(findValue, "g");
        let result = string.match(pattern);

        var countFind = 0;
        if (result) {
            for (var i = 0; i < result.length; i++) {
                if (result[i] === findValue) {
                    countFind++;
                }
            }
        } else {
            alert("LoL!, This sting is not exist");
        }
        if (result) {
            document.getElementById(
                "ResultVal"
            ).innerHTML = `A sting value is "${result[0]}" and this string length is (${countFind}).`;
        }
    };
    return (
        <>
            <p>
                Lorem ipsum dolor sit amet sit amet consectetur adipisicing elit
                sit amet. Repellendus sit amet magnam iste voluptates nobis ebitis
                facilis molestiae cupiditate consequuntur delectus non quae ut
                aliquid nesciunt voluptas placeat, qui myName aut reiciendis!
            </p>
            <div id="ResultVal"></div>
            <form onSubmit={handleSubmit}>
                <label>
                    Enter Find value:
                    <input
                        type="text"
                        value={findValue}
                        onChange={(e) => setFindValue(e.target.value)}
                        required={true}
                    />
                </label>
                <input type="submit" />
            </form>
        </>
    );
}

export default Filter_Regular_Expression;
