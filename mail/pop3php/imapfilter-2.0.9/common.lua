-- Common functions for all classes.

function _check_required(arg, argtype)
    if (type(arg) == 'nil') then
        error('required argument left out', 3)
    else
        _check_optional(arg, argtype)
    end
end

function _check_optional(arg, argtype)
    if (type(arg) ~= 'nil') then
        if (type(argtype) == 'string') then
            if (type(arg) ~= argtype) then
                error(argtype .. ' argument expected, got ' .. type(arg), 3)
            end
        elseif (type(argtype) == 'table') then
            local b = false
            for _, t in ipairs(argtype) do
                if (type(arg) == t) then
                    b = true
                end
            end
            if (b == false) then
                error(argtype .. ' argument expected, got ' .. type(arg), 3)
            end
        end
    end
end


function _make_normal(messages)
    local m = {}
    for k, _ in pairs(messages) do
        table.insert(m, k)
    end
    return m
end


function _make_range(messages)
    table.sort(messages)

    local t = {}
    local a, z
    for _, m in ipairs(messages) do
        if a == nil or z == nil then
            a = m
            z = m
        else
            if m == z + 1 then
                z = m
            else
                if a == z then
                    table.insert(t, tostring(a))
                else
                    table.insert(t, a .. ':' .. z)
                end
                a = m
                z = m
            end
        end
    end

    if a == z then
        table.insert(t, tostring(a))
    else
        table.insert(t, a .. ':' .. z)
    end

    return t
end


function _make_query(criteria)
    local s = 'ALL '

    if (criteria.invert ~= true) then
        for ka, va in ipairs(criteria) do
            if (type(va) == 'string') then
                s = s .. '' .. '(' .. va .. ')' .. ' '
            elseif (type(va) == 'table') then
                for i = 1, #va - 1 do
                    s = s .. 'OR '
                end
                for ko, vo in ipairs(va) do
                    if (type(vo) ~= 'string') then
                        error('filter rule not a string', 2)
                    end
                    s = s .. '(' .. vo .. ') '
                end
            else
                error('filter element not a string or table', 2)
            end
        end
    else
        for i = 1, #criteria - 1 do
            s = s .. 'OR '
        end
        for ko, vo in ipairs(criteria) do
            if (type(vo) == 'string') then
                s = s .. '' .. '(' .. vo .. ')' .. ' '
            elseif (type(vo) == 'table') then
                s = s .. '('
                for ka, va in ipairs(vo) do
                    if (type(va) ~= 'string') then
                        error('filter rule not a string', 2)
                    end
                    s = s .. va .. ' '
                end
                s = string.gsub(s, '(.+) ', '%1')
                s = s .. ') '
            else
                error('filter rule not a string or table', 2)
            end
        end
    end

    s = string.gsub(s, '(.+) ', '%1')

    return s
end
