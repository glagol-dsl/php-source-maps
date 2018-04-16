# Glagol DSL Source Maps library
[![CircleCI](https://circleci.com/gh/glagol-dsl/php-source-maps.svg?style=svg)](https://circleci.com/gh/glagol-dsl/php-source-maps)

**Note:** this is a source maps consumer implementation with modifications to its algorithm to satisfy the needs of Glagol DSL

## Rationale
While PHP exception stack traces do give line numbers - columns are not provided. 
Hence mapping traces to original Glagol code becomes difficult. 
This is the reason why Glagol DSL Source Maps reference the generated symbol names instead of the original (the way it is originally defined in Source Maps revision 3) within the mapping.

