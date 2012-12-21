-- A simple implementation of sets.

Set = {}

Set.mt = {}
setmetatable(Set, Set.mt)


function Set.new(self, values) 
    local set = {}

    setmetatable(set, Set.mt)

    if (type(values) == 'table') then
        for _, v in ipairs(values) do
            set[v] = true
        end
    end

    return set
end

function Set.union(seta, setb)
    local set = Set()

    for k in pairs(seta) do
        set[k] = true
    end

    for k in pairs(setb) do
        set[k] = true
    end

    return set
end

function Set.intersection(seta, setb)
    local set = Set()

    for k in pairs(seta) do
        set[k] = setb[k]
    end

    return set
end

function Set.difference(seta, setb)
    local set = Set()

    for k in pairs(seta) do
        if (setb[k] ~= true) then
            set[k] = seta[k]
        end
    end

    return set
end


Set.mt.__call = Set.new
Set.mt.__add = Set.union
Set.mt.__mul = Set.intersection
Set.mt.__sub = Set.difference
