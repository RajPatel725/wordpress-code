import React, { forwardRef } from "react";

function ForwardRefH(props, ref){
    return(
        <>
            <textarea type="text" ref={ref} />
        </>
    )
}

export default forwardRef(ForwardRefH);