import React, { Component } from 'react';
import CssBaseline from '@mui/material/CssBaseline';
import Container from '@mui/material/Container';

class Wrapper extends Component {
    render() {
        return (
            <React.Fragment>
                <CssBaseline />
                <Container maxWidth="sm">
                    { this.props.children }
                </Container>
            </React.Fragment>
        );
    }
}

export default Wrapper;
