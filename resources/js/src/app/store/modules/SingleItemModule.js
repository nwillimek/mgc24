const state =
    {
        variation: {},
        variationList: [],
        variationOrderQuantity: 1
    };

const mutations =
    {
        setVariation(state, variation)
        {
            state.variation = variation;
            if (variation.documents.length > 0 && variation.documents[0].data.variation)
            {
                state.variationOrderQuantity = variation.documents[0].data.variation.minimumOrderQuantity || 1;
            }
        },

        setVariationList(state, variationList)
        {
            state.variationList = variationList;
        },

        setVariationOrderProperty(state, {propertyId, value})
        {
            const index = state.variation.documents[0].data.properties.findIndex(property => property.property.id === propertyId);

            if (index >= 0)
            {
                Vue.set(state.variation.documents[0].data.properties[index], "property",
                    {
                        ...state.variation.documents[0].data.properties[index].property,
                        value: value
                    });
            }
        },

        setVariationOrderQuantity(state, quantity)
        {
            state.variationOrderQuantity = quantity;
        }
    };

const actions =
    {
    };

const getters =
    {
        variationPropertySurcharge(state)
        {
            if (!state || !state.variation.documents)
            {
                return 0;
            }

            let sum = 0;

            if (state.variation.documents[0].data.properties)
            {
                const addedProperties = state.variation.documents[0].data.properties.filter(property =>
                    {
                    return !!property.property.value;
                });

                for (const property of addedProperties)
                    {
                    sum += property.property.surcharge;
                }
            }

            return sum;
        },

        variationGraduatedPrice(state)
        {
            if (!state || !state.variation.documents)
            {
                return null;
            }

            const calculatedPrices = state.variation.documents[0].data.prices;
            const graduatedPrices = calculatedPrices.graduatedPrices;

            let returnPrice;

            if (graduatedPrices && graduatedPrices[0])
            {
                const prices = graduatedPrices.filter(price =>
                {
                    return parseFloat(state.variationOrderQuantity) >= price.minimumOrderQuantity;
                });

                if (prices[0])
                {
                    returnPrice = prices.reduce((prev, current) => (prev.minimumOrderQuantity > current.minimumOrderQuantity) ? prev : current);
                    // returnPrice = returnPrice.unitPrice.value;
                }
            }

            return returnPrice || calculatedPrices.default;
        },

        variationTotalPrice(state, getters, rootState, rootGetters)
        {
            const graduatedPrice = getters.variationGraduatedPrice;

            return getters.variationPropertySurcharge + (graduatedPrice ? getters.variationGraduatedPrice.unitPrice.value : 0);
        }
    };

export default
{
    state,
    mutations,
    actions,
    getters
};
